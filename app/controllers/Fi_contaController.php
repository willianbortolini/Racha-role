<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Fi_contaService;
use app\core\Flash;
use app\models\service\Service;

class Fi_contaController extends Controller
{
    private $tabela = "fi_conta";
    private $campo = "fi_conta_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function index()
    {
        $dados["fi_conta"] = Service::get($this->tabela, 'usuarios_id', $_SESSION['id'], true);
        $dados["view"] = "Fi_conta/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["fi_conta"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Fi_conta/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["fi_conta"] = Flash::getForm();
        $dados["view"] = "Fi_conta/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];

                // Excluir a imagem, se existir               

                // Excluir
                Fi_contaService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $fi_conta = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["fi_conta_id"]) && is_numeric($_POST["fi_conta_id"]) && $_POST["fi_conta_id"] > 0) {
                    $fi_conta->fi_conta_id = $_POST["fi_conta_id"];
                } else {
                    $fi_conta->fi_conta_id = 0;
                }
                if (isset($_POST["fi_conta_nome"]))
                    $fi_conta->fi_conta_nome = $_POST["fi_conta_nome"];

                $fi_conta->usuarios_id = $_SESSION['id'];


            }


            Flash::setForm($fi_conta);
            if (Fi_contaService::salvar($fi_conta, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Fi_conta");
            } else {
                if (!$fi_conta->fi_conta_id) {
                    $this->redirect(URL_BASE . "Fi_conta/create");
                } else {
                    $this->redirect(URL_BASE . "Fi_conta/edit/" . $fi_conta->fi_conta_id);
                }
            }
        }
    }

}
