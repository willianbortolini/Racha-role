<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Flash;
use app\models\service\LoginService;
use app\models\service\Service;
use app\models\service\UsersService;

class LoginController extends Controller
{

    public function index()
    {
        $dados["authUrl"] = LoginService::urlGoogle();
        $dados["view"] = "login";
        $this->load("template", $dados);
    }

    public function login($curso = 0)
    {
        $dados["curso"] = $curso;
        $dados["view"] = "login";
        $this->load("template", $dados);
    }

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
        $usuario = Service::getGeral("Users", "email", "=", $email);

        if ($usuario) {
            //coloca o codigo no capo de recuperação
            $stringParaCriptografar = "f" . $usuario->Users_id . "d" . hoje();
            $st = crypt($stringParaCriptografar, 'rl');
            $codigo_acesso = slug($st);
            $Users_id = $usuario->Users_id;
            Service::editar(["Users_id" => $Users_id, "recuperacao" => $codigo_acesso], "Users_id", "Users");
            $corpoEmail = "<style type='text/css'>"
                . ".botao-email{border: solid 1px #21dc85;background: #60e2a6;cursor: pointer;font-size: 17px;padding: 5px 30px;margin: 5px;text-align: center;text-transform: uppercase;text-decoration: none;color:black;}"
                . "</style>"
                . "Recuperação de senha cursoswill <br>"
                . "Clique no botão abaixo para cadastrar uma nova senha.<br>"
                . "<p><a class='botao-email' href='" . URL_BASE . "login/redefinirSenha/" . $codigo_acesso . "'>Redefinir</a></p><br>";

            $de = "recuperacaosenha@cursoswill.site";
            $from = "solicitacao@cursoswill.site";
            $resposta = Service::email($usuario->email, "Recuperação senha W9B2", $corpoEmail, $de, $from);
            Flash::setMsg("Email de recuperação enviado ", 1);
            $this->redirect(URL_BASE . "Login");
        } else {
            $this->redirect(URL_BASE . "Login");
        }
    }

    public function redefinirSenha($codigo)
    {

        if ($codigo != "") {
            $usuario = Service::getGeral("Users", "recuperacao", "=", $codigo);
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
        $usuario->senha = $_POST['senha'];
        $usuario->confirmacao = $_POST['confirmacao'];
        $usuario->recuperacao = "";
        $recuperacao = $_POST['recuperacao'];

        Flash::setForm($usuario);
        if (UsersService::recuperaSenha($usuario, "usuario_id", "users")) {
            $retornoUsusario = LoginService::login($getUsuario->email, $_POST['senha']);

            if ($retornoUsusario == 1) {
                $this->redirect(URL_BASE);
            } else {
                $dados["erro"] = "Email ou senha invalidos";
                $this->redirect(URL_BASE . "Login/redefinirSenha/" . $recuperacao);
            }
        } else {
            $this->redirect(URL_BASE . "Login/redefinirSenha/" . $getUsuario->recuperacao);
        }
    }

}