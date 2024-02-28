<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\InventarioService;
use app\core\Flash;
use app\models\service\Service;

class InventarioController extends Controller
{
    private $tabela = "inventario";
    private $campo = "inventario_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE  . "login");
            exit;
        }
    }

    public function index()
    {
        $dados["inventario"] = Service::get($this->tabela,'usuarios_id', $_SESSION['id'],true);
        $dados["view"] = "Inventario/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["inventario"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Inventario/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["inventario"] = Flash::getForm();
        $dados["view"] = "Inventario/Edit";
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
                InventarioService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $inventario = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["inventario_id"]) && is_numeric($_POST["inventario_id"]) && $_POST["inventario_id"] > 0) {                  
                    $inventario->inventario_id = $_POST["inventario_id"];                    
                } else {
                    $inventario->inventario_id = 0;                         
                }
                                if (isset($_POST["nome"]))
                   $inventario->nome = $_POST["nome"];
                if (isset($_POST["localizacao"]))
                   $inventario->localizacao = $_POST["localizacao"];
                if (isset($_POST["responsavel"]))
                   $inventario->responsavel = $_POST["responsavel"];
                if (isset($_POST["usuarios_id"]))
                   $inventario->usuarios_id = $_POST["usuarios_id"];
                
               
            }


            Flash::setForm($inventario);
            if (InventarioService::salvar($inventario, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Inventario");
            } else {
                if (!$inventario->inventario_id) {
                    $this->redirect(URL_BASE   . "Inventario/create");
                } else {
                    $this->redirect(URL_BASE   . "Inventario/edit/" . $inventario->inventario_id);
                }
            }
        }
    }

}
