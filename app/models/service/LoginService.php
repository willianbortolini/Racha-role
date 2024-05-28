<?php

namespace app\models\service;

use app\models\validacao\LoginValidacao;
use app\models\dao\LoginDao;
use app\core\Flash;
use app\models\service\Service;

use Google\Client;
use Google\Service\Oauth2 as ServiceOauth2;
use GuzzleHttp\Client as GuzzleClient;
use Google\Service\Oauth2\Userinfo;
use app\models\service\UsersService;

class LoginService
{

    public static function urlGoogle()
    {
        $client = new Client;

        $guzzleClient = new GuzzleClient(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
        $client->setHttpClient($guzzleClient);
        $client->setAuthConfig('credentials_google.json');
        $client->setRedirectUri(URL_BASE.'login/google');
        $client->addScope('email');
        $client->addScope('profile');
        return $client->createAuthUrl();
    }

    public static function loginGoogle($code)
    {
        $client = new Client;
        $guzzleClient = new GuzzleClient(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
        $client->setHttpClient($guzzleClient);
        $client->setAuthConfig('credentials_google.json');
        $client->setRedirectUri(URL_BASE.'login/google');
        $client->addScope('email');
        $client->addScope('profile');

        $token = $client->fetchAccessTokenWithAuthCode($code);
        $client->setAccessToken($token['access_token']);
        $googleService = new ServiceOauth2($client);
        $usuarioGoogle = $googleService->userinfo->get();
        return self::loginPorEmail($usuarioGoogle->email,$usuarioGoogle->name);
       
    }

    public static function loginPorEmail($email,$nome = ' '){

        $resultado = service::get("users","email",$email);        
        if ($resultado) {
            //se tem loga
            $_SESSION['id'] = $resultado->users_id;
            $_SESSION['nivel'] = $resultado->nivel_de_acesso;
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrfToken;           
            return 1;
        } else {
            //se não tem cria novo usuario 
            $novoUsuario = new \stdClass();
            $novoUsuario->email = $email;
            $novoUsuario->username = $nome;
            $novoUsuario->password = $nome . '_Cadeopix1';
            $novoUsuario->confirmacao = $novoUsuario->password;
            $novoUsuario->cookies = 1;
            $novoUsuario->politica = 1;
            $novoUsuario->users_id = 0;
            
            $usuarioCriado = UsersService::salvar($novoUsuario, "users_id", "users");
            if ($usuarioCriado) {                
                $_SESSION['id'] = $usuarioCriado;
                $_SESSION['nivel'] = 1;
                $csrfToken = bin2hex(random_bytes(32));
                $_SESSION['csrf_token'] = $csrfToken;                
                return 1;
            }
        }

    }

    public static function login($email, $password)
    {
        $valida = new \stdClass();

        $valida->email = $email;
        $valida->password = $password;
        
        $validacao = LoginValidacao::login($valida);
        $erros = $validacao->listaErros();
        
        if (!$erros) {            
            $resultado = service::get("users","email",$valida->email);        
            if ($resultado) {
                if (password_verify($password, $resultado->password)) {
                    $_SESSION['id'] = $resultado->users_id;
                    $csrfToken = bin2hex(random_bytes(32));
                    $_SESSION['csrf_token'] = $csrfToken;                    
                    return 1;
                }
            }
            Flash::setMsg("Login ou senha não encontrados", -1);
            session_destroy();
            return 0;
        } else {
            Flash::limpaErro();
            Flash::setErro($erros);
            return 0;
        }

    }


}
