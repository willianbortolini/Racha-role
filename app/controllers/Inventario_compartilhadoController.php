<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Inventario_compartilhadoService;
use app\core\Flash;
use app\models\service\Service;

class Inventario_compartilhadoController extends Controller
{
    private $tabela = "inventario_compartilhado";
    private $campo = "inventario_compartilhado_id";
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

    /*public function index()
    {
        $dados["inventario_compartilhado"] = Service::lista($this->tabela);
        $dados["view"] = "Inventario_compartilhado/Show";
        $this->load("templateBootstrap", $dados);
    }*/

    public function membros($inventario_id)
    {
        $dados["inventario_compartilhado"] = Service::get('vw_inventario_compartilhado', 'inventario_id', $inventario_id, true);
        $dados["view"] = "Inventario_compartilhado/Show";
        $this->load("templateBootstrap", $dados);
    }


    public function edit($id)
    {
        $dados["inventario_compartilhado"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Inventario_compartilhado/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["inventario_compartilhado"] = Flash::getForm();
        $dados["view"] = "Inventario_compartilhado/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Inventario_compartilhadoService::excluir($id);
            }
        }
    }

    public function desabilitar($inventario_compartilhado_id)
    {
        $inventario_compartilhado = new \stdClass();
        $inventario_compartilhado->inventario_compartilhado_id = $inventario_compartilhado_id;
        $inventario_compartilhado->habilitado = 0;

        Inventario_compartilhadoService::salvar($inventario_compartilhado);
        $inventario = Service::get($this->tabela, $this->campo,$inventario_compartilhado_id);
        $this->redirect(URL_BASE . "Inventario_compartilhado/membros/".$inventario->inventario_id);      
    }

    public function habilitar($inventario_compartilhado_id)
    {
        $inventario_compartilhado = new \stdClass();
        $inventario_compartilhado->inventario_compartilhado_id = $inventario_compartilhado_id;
        $inventario_compartilhado->habilitado = 1;

        Inventario_compartilhadoService::salvar($inventario_compartilhado);
        $inventario = Service::get($this->tabela, $this->campo,$inventario_compartilhado_id);
        $this->redirect(URL_BASE . "Inventario_compartilhado/membros/".$inventario->inventario_id);      
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $inventario_compartilhado = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["inventario_compartilhado_id"]) && is_numeric($_POST["inventario_compartilhado_id"]) && $_POST["inventario_compartilhado_id"] > 0) {
                    $inventario_compartilhado->inventario_compartilhado_id = $_POST["inventario_compartilhado_id"];
                } else {
                    $inventario_compartilhado->inventario_compartilhado_id = 0;
                }
                if (isset($_POST["inventario_id"]))
                    $inventario_compartilhado->inventario_id = $_POST["inventario_id"];
                if (isset($_POST["usuario_id"]))
                    $inventario_compartilhado->usuario_id = $_POST["usuario_id"];


            }


            Flash::setForm($inventario_compartilhado);
            if (Inventario_compartilhadoService::salvar($inventario_compartilhado) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Inventario_compartilhado");
            } else {
                if (!$inventario_compartilhado->inventario_compartilhado_id) {
                    $this->redirect(URL_BASE . "Inventario_compartilhado/create");
                } else {
                    $this->redirect(URL_BASE . "Inventario_compartilhado/edit/" . $inventario_compartilhado->inventario_compartilhado_id);
                }
            }
        }
    }

}
