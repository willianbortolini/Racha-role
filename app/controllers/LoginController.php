<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Flash;
use app\models\service\LoginService;
use app\models\service\Service;
use app\models\service\UsersService;

class LoginController extends Controller
{

    public function index($grupo = 0)
    {
        $dados["authUrl"] = LoginService::urlGoogle();
        if ($grupo > 0) {
            $_SESSION['group_id'] = $grupo;
        }
        $dados["view"] = "login";
        $this->load("template", $dados);
    }

    /*public function login($grupo = 0)
    {
        $dados["grupo"] = $grupo;
        $dados["view"] = "login";
        $this->load("template", $dados);
    }*/

    public function google()
    {
        if (isset($_GET['code'])) {
            LoginService::loginGoogle($_GET['code']);
            Flash::limpaErro();
            Flash::limpaMsg();
            $this->redirect(URL_BASE);
        }
    }

    public function esqueci()
    {
        $dados["view"] = "esqueciMinhaSenha";
        $this->load("template", $dados);
    }

    public function logar()
    {
        $email = isset($_POST["email"]) ? filter_input(INPUT_POST, "email") : null;
        $senha = isset($_POST["senha"]) ? filter_input(INPUT_POST, "senha") : null;

        Flash::setForm($_POST);

        $retornoUsusario = LoginService::login($email, $senha);

        if ($retornoUsusario == 1) {
            Flash::limpaErro();
            Flash::limpaMsg();
            $this->redirect(URL_BASE);
        } else {
            $dados["erro"] = "Email ou senha invalidos";
            $dados["view"] = "login";
            $this->load("template", $dados);
        }
    }

    public function loginComToken()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['token'])) {
            $usuarios = Service::get("users", "auth_token", $data['token']);

            if(isset($usuarios->email)){
                if(LoginService::loginPorEmail($usuarios->email) == 1){
                    Flash::limpaMsg();
                    echo json_encode(['status' => 'ok']);
                }
            } else {
                // Token inválido
                Flash::limpaMsg();
                echo json_encode(['status' => 'invalid']);
            }
        } else {
            // Nenhum token fornecido
            Flash::limpaMsg();
            echo json_encode(['status' => 'error', 'message' => 'No token provided']);
        }
    }

    public function aceitarCookies()
    {
        $_SESSION["cookies"] = true;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function logoff()
    {
        session_destroy();
        $this->redirect(URL_BASE . "login");
    }

    public function recuperarSenha()
    {
        $email = isset($_POST["email"]) ? filter_input(INPUT_POST, "email") : null;
        $usuario = Service::getGeral("users", "email", "=", $email);

        if ($usuario) {
            //coloca o codigo no capo de recuperação
            $stringParaCriptografar = "f" . $usuario->users_id . "d" . hoje();
            $st = crypt($stringParaCriptografar, 'rl');
            $codigo_acesso = slug($st);
            $Users_id = $usuario->users_id;
            Service::editar(["users_id" => $Users_id, "recuperacao" => $codigo_acesso], "users_id", "users");
            $corpoEmail = "<style type='text/css'>"
                . ".botao-email{border: solid 1px #21dc85;background: #60e2a6;cursor: pointer;font-size: 17px;padding: 5px 30px;margin: 5px;text-align: center;text-transform: uppercase;text-decoration: none;color:black;}"
                . "</style>"
                . "Recuperação de senha racharole <br>"
                . "Clique no botão abaixo para cadastrar uma nova senha.<br>"
                . "<p><a class='botao-email' href='" . URL_BASE . "login/redefinirSenha/" . $codigo_acesso . "'>Redefinir</a></p><br>";

            $de = "recuperacaosenha@invtrack.tech";
            $from = "solicitacao@racharole.site";
            $resposta = Service::email($usuario->email, "Recuperação senha W9B2", $corpoEmail, $de, $from);
            Flash::setMsg("Email de recuperação enviado ", 1);
            $this->redirect(URL_BASE);
        } else {
            $this->redirect(URL_BASE);
        }
    }

    public function redefinirSenha($codigo)
    {

        if ($codigo != "") {
            $usuario = Service::getGeral("users", "recuperacao", "=", $codigo);
            if ($usuario) {
                $dados["usuario"] = $usuario;
                $dados["view"] = "redefinir_senha";
                $this->load("template", $dados);
            } else {
                Flash::setMsg("Codigo expirado", -1);
                $this->redirect(URL_BASE . "login");
            }
        }
    }

    public function redefinirSenhaSalvar()
    {
        $usuario = new \stdClass();
        $usuario->users_id = $_POST["users_id"];
        $getUsuario = Service::getGeral("users", "users_id", "=", $usuario->users_id);
        $usuario->password = $_POST['password'];
        $usuario->confirmacao = $_POST['confirmacao'];
        $usuario->recuperacao = "";
        Flash::setForm($usuario);
        if (UsersService::recuperaSenha($usuario, "users_id", "users") > 0) {
            $retornoUsusario = LoginService::login($getUsuario->email, $_POST['password']);
            if ($retornoUsusario == 1) {
                $this->redirect(URL_BASE);
            } else {
                $dados["erro"] = "Email ou senha invalidos";
                $this->redirect(URL_BASE . "Login/redefinirSenha/" . $getUsuario->recuperacao);
            }
        } else {
            $this->redirect(URL_BASE . "Login/redefinirSenha/" . $getUsuario->recuperacao);
        }
    }

}