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
use app\models\service\UsuarioService;

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

        $resultado = service::get("usuarios","email",$email);
        
        if ($resultado) {
            //se tem loga
            $_SESSION['id'] = $resultado->usuarios_id;
            $_SESSION['nivel'] = $resultado->nivel_de_acesso;
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrfToken;

            //salva o acesso
            $validaSalva = [];
            $dataQtdLogin = new \stdClass();
            $dataQtdLogin->usuarios_id = $resultado->usuarios_id;
            date_default_timezone_set('America/Sao_Paulo');
            $hoje = date('Y-m-d H:i:s');
            $dataQtdLogin->ultimo_acesso = $hoje;
            $dataQtdLogin->qtd_acessos = $resultado->qtd_acessos + 1;
            Service::salvar($dataQtdLogin, "usuarios_id", $validaSalva, "usuarios");
            return 1;
        } else {
            //se não tem cria novo usuario 
            $novoUsuario = new \stdClass();
            $novoUsuario->email = $email;
            $novoUsuario->usuario = $nome;
            $novoUsuario->senha = $nome . '_Curso1';
            $novoUsuario->confirmacao = $novoUsuario->senha;
            $novoUsuario->cookies = 1;
            $novoUsuario->politica = 1;
            $novoUsuario->usuarios_id = 0;
            $novoUsuario->nivel_de_acesso = 1;
            
            $usuarioCriado = UsuarioService::salvar($novoUsuario, "usuarios_id", "usuarios");
            if ($usuarioCriado) {
                
                $_SESSION['id'] = $usuarioCriado;
                $_SESSION['nivel'] = 1;
                $csrfToken = bin2hex(random_bytes(32));
                $_SESSION['csrf_token'] = $csrfToken;
                return 1;
            }
        }

    }

    public static function login($email, $senha)
    {
        $valida = new \stdClass();

        $valida->email = $email;
        $valida->senha = $senha;
        
        $validacao = LoginValidacao::login($valida);
        $erros = $validacao->listaErros();
        
        if (!$erros) {
            $resultado = service::get("usuarios","email",$valida->email);           
            if ($resultado) {
                if (password_verify($senha, $resultado->senha)) {
                    $_SESSION['id'] = $resultado->usuarios_id;
                    $_SESSION['nivel'] = $resultado->nivel_de_acesso;
                    $csrfToken = bin2hex(random_bytes(32));
                    $_SESSION['csrf_token'] = $csrfToken;

                    //salva o acesso
                    $validaSalva = [];
                    $dataQtdLogin = new \stdClass();
                    $dataQtdLogin->usuarios_id = $resultado->usuarios_id;
                    date_default_timezone_set('America/Sao_Paulo');
                    $hoje = date('Y-m-d H:i:s');
                    $dataQtdLogin->ultimo_acesso = $hoje;
                    $dataQtdLogin->qtd_acessos = $resultado->qtd_acessos + 1;
                    Service::salvar($dataQtdLogin, "usuarios_id", $validaSalva, "usuarios");
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
