<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Fi_categoriasService;
use app\core\Flash;
use app\models\service\Service;

class Fi_categoriasController extends Controller
{
    private $tabela = "fi_categorias";
    private $campo = "fi_categorias_id";
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
        $dados["fi_categorias"] = Service::get($this->tabela, 'usuarios_id', $_SESSION['id'], true);
        $dados["view"] = "Fi_categorias/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["fi_categorias"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Fi_categorias/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["fi_categorias"] = Flash::getForm();
        $dados["view"] = "Fi_categorias/Edit";
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
                Fi_categoriasService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $fi_categorias = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["fi_categorias_id"]) && is_numeric($_POST["fi_categorias_id"]) && $_POST["fi_categorias_id"] > 0) {
                    $fi_categorias->fi_categorias_id = $_POST["fi_categorias_id"];
                } else {
                    $fi_categorias->fi_categorias_id = 0;
                }
                if (isset($_POST["fi_categorias_nome"]))
                    $fi_categorias->fi_categorias_nome = $_POST["fi_categorias_nome"];

                $fi_categorias->usuarios_id = $_SESSION['id'];


            }


            Flash::setForm($fi_categorias);
            if (Fi_categoriasService::salvar($fi_categorias, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Fi_categorias");
            } else {
                if (!$fi_categorias->fi_categorias_id) {
                    $this->redirect(URL_BASE . "Fi_categorias/create");
                } else {
                    $this->redirect(URL_BASE . "Fi_categorias/edit/" . $fi_categorias->fi_categorias_id);
                }
            }
        }
    }

}
