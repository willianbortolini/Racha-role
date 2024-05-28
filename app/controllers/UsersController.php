<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\UsersService;
use app\models\service\LoginService;

class UsersController extends Controller
{

    private $tabela = "users";
    private $campo = "users_id";

    public function index()
    {
        $dados["view"] = "Users/Create";
        $this->load("Users/Create", $dados);
    }

    public function create($curso = 0)
    {
        $dados["users"] = Flash::getForm();
        $dados["view"] = "Users/Create";
        $this->load("template", $dados);
    }

    public function edit($id)
    {
        //$empresa = $_SESSION[SESSION_LOGIN]->id_User;
        $User = Service::get($this->tabela, $this->campo, $id);
        $dados["categoria"] = Service::lista("categoria");
        $dados["unidade"] = Service::lista("unidade");
        if (!$User) {
            $this->redirect(URL_BASE . "Users");
        }

        $dados["User"] = $User;
        $dados["view"] = "Users/Create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $User = new \stdClass();
        $User->users_id = 0;
        $User->email = $_POST["email"];
        $User->password = $_POST['password'];
        $User->confirmacao = $_POST['confirmacao'];
        $User->politica = (isset($_POST['politica']) && $_POST['politica'] == 'on') ? 1 : 0;
        $User->cookies = (isset($_POST['cookies']) && $_POST['cookies'] == 'on') ? 1 : 0;

        Flash::setForm($User);

        if (UsersService::salvar($User, $this->campo, $this->tabela)) {
            $retornoUsusario = LoginService::login( $User->email, $_POST['password']);
            if ($retornoUsusario == 1) {
                Flash::limpaErro();
                Flash::limpaMsg();
                $this->redirect(URL_BASE);
            } else {
                $dados["erro"] = "Email ou senha invalidos";
                $this->load("login", $dados);
            }
        } else {
            $this->redirect(URL_BASE . "Users/Create");
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "Users");
    }

    public function buscar($q)
    {
        $User = Service::getLike($this->tabela, "Users", $q, true);
        echo json_encode($User);
    }

}
