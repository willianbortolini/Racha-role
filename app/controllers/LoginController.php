<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Flash;
use app\models\service\LoginService;
use app\models\service\Service;
use app\models\service\UserService;

class LoginController extends Controller
{
    private $usuario;
    public function index()
    {
        $dados["view"] = "login";
        $this->load("template", $dados);
    }

    public function login()
    {
        $dados["view"] = "login";
        $this->load("template", $dados);
    }

    public function esqueci()
    {
        $dados["view"] = "esqueciMinhaSenha";
        $this->load("template", $dados);
    }


    public function logar()
    {
        $usuario = isset($_POST["usuario"]) ? filter_input(INPUT_POST, "usuario") : null;
        $senha = isset($_POST["senha"]) ? filter_input(INPUT_POST, "senha") : null;
        Flash::setForm($_POST);  
        $retornoUsusario = LoginService::loginSemRecaptcha("email", $usuario, $senha, "usuarios");
        if ($retornoUsusario == 1) {
            Flash::limpaErro();
            Flash::limpaMsg();
            $this->redirect(URL_BASE . "home");
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
        $usuario = Service::getGeral("usuarios", "email", "=", $email);

        if ($usuario) {
            //coloca o codigo no capo de recuperação
            $codigo_acesso = uniqid();
            $usuarios_id = $usuario->usuarios_id;
            Service::editar(["usuarios_id" => $usuarios_id, "recuperacao" => $codigo_acesso], "usuarios_id", "usuarios");

            $corpoEmail = "<style type='text/css'>"
                . ".botao-email{border: solid 1px #21dc85;background: #60e2a6;cursor: pointer;font-size: 17px;padding: 5px 30px;margin: 5px;text-align: center;text-transform: uppercase;text-decoration: none;color:black;}"
                . "</style>"
                . "Recuperação de senha represnetante Indaflex<br>"
                . "Clique no botão link para cadastrar uma nova senha.<br>"
                . "<p><a class='botao-email' href='" . URL_BASE . "login/redefinirSenha/" . $codigo_acesso . "'>Redefinir</a></p><br>";

            $de = "recuperacaosenha@w9b2.com";
            $from = "solicitacao@w9b2.com";

            if (DOCKER_CONTAINER == false) {
                $resposta = Service::email($usuario->email, "Recuperação senha", $corpoEmail, $de, $from);
            }

            Flash::setMsg("E-mail de recuperação enviado, isso pode levar alguns minutos, cheque sua caixa de entrada.", 1);
            $this->redirect(URL_BASE . "login");
        } else {
            $this->redirect(URL_BASE . "login");
        }
    }

    public function redefinirSenha($codigo)
    {

        if ($codigo != "") {
            $usuario = Service::getGeral("usuarios", "recuperacao", "=", $codigo);
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

        $usuario->usuarios_id = $_POST["usuarios_id"];
        $getUsuario = Service::getGeral("usuarios", "usuarios_id", "=", $usuario->usuarios_id);

        $usuario->senha = $_POST['senha'];
        $usuario->confirmacao = $_POST['confirmacao'];
        $usuario->recuperacao = "";

        Flash::setForm($usuario);
        if (UserService::recuperaSenha($usuario, "usuarios_id", "usuarios")) {

            $retornoUsusario = LoginService::loginSemRecaptcha("email", $getUsuario->email, $_POST['senha'], "usuarios");
            if ($retornoUsusario == 1) {
                Flash::limpaErro();
                Flash::limpaMsg();
                $this->redirect(URL_BASE . "home");
            } else {
                $dados["erro"] = "Email ou senha invalidos";
                $this->redirect(URL_BASE . "Login");
            }
        } else {
            $this->redirect(URL_BASE . "Login/redefinirSenha/" . $getUsuario->recuperacao);
        }
    }
}
