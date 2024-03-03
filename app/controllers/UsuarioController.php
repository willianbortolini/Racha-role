<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\UsuarioService;
use app\models\service\LoginService;

class UsuarioController extends Controller
{

    private $tabela = "usuarios";
    private $campo = "usuarios_id";

    public function index()
    {
        $dados["view"] = "Usuario/Create";
        $this->load("Usuario/Create", $dados);
    }

    public function create($curso = 0)
    {
        $dados["usuarios"] = Flash::getForm();
        $dados["view"] = "Usuario/Create";
        $this->load("Usuario/Create", $dados);
    }

    public function edit($id)
    {
        //$empresa = $_SESSION[SESSION_LOGIN]->id_usuario;
        $usuario = Service::get($this->tabela, $this->campo, $id);
        $dados["categoria"] = Service::lista("categoria");
        $dados["unidade"] = Service::lista("unidade");
        if (!$usuario) {
            $this->redirect(URL_BASE . "usuario");
        }

        $dados["usuario"] = $usuario;
        $dados["view"] = "Usuario/Create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $usuario = new \stdClass();
        $usuario->usuarios_id = 0;
        $usuario->email = $_POST["email"];
        $usuario->senha = $_POST['senha'];
        $usuario->confirmacao = $_POST['confirmacao'];
        $usuario->nivel_de_acesso = 1;
        $usuario->data_cadastro = dataHoraSP();
        $usuario->politica = (isset($_POST['politica']) && $_POST['politica'] == 'on') ? 1 : 0;
        $usuario->cookies = (isset($_POST['cookies']) && $_POST['cookies'] == 'on') ? 1 : 0;

        Flash::setForm($usuario);

        if (UsuarioService::salvar($usuario, $this->campo, $this->tabela)) {
            $retornoUsusario = LoginService::login( $usuario->email, $_POST['senha']);
            if ($retornoUsusario == 1) {
                Flash::limpaErro();
                Flash::limpaMsg();
                $this->redirect(URL_BASE);
            } else {
                $dados["erro"] = "Email ou senha invalidos";
                $this->load("login", $dados);
            }
        } else {
            $this->redirect(URL_BASE . "Usuario/Create");
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "usuario");
    }

    public function buscar($q)
    {
        $usuario = Service::getLike($this->tabela, "usuario", $q, true);
        echo json_encode($usuario);
    }

}
