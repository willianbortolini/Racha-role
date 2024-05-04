<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Composicao_tipoService;
use app\core\Flash;
use app\models\service\Service;

class Composicao_tipoController extends Controller
{
    private $tabela = "composicao_tipo";
    private $campo = "composicao_tipo_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
    }

    public function index()
    {
        $dados["composicao_tipo"] = Service::lista($this->tabela);
        $dados["view"] = "Composicao_tipo/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["composicao_tipo"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Composicao_tipo/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["composicao_tipo"] = Flash::getForm();
        $dados["view"] = "Composicao_tipo/Edit";
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
                Composicao_tipoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $composicao_tipo = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["composicao_tipo_id"]) && is_numeric($_POST["composicao_tipo_id"]) && $_POST["composicao_tipo_id"] > 0) {                  
                    $composicao_tipo->composicao_tipo_id = $_POST["composicao_tipo_id"];                    
                } else {
                    $composicao_tipo->composicao_tipo_id = 0;                         
                }
                                if (isset($_POST["composicao_tipo_nome"]))
                   $composicao_tipo->composicao_tipo_nome = $_POST["composicao_tipo_nome"];
                
               
            }


            Flash::setForm($composicao_tipo);
            if (Composicao_tipoService::salvar($composicao_tipo, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Composicao_tipo");
            } else {
                if (!$composicao_tipo->composicao_tipo_id) {
                    $this->redirect(URL_BASE   . "Composicao_tipo/create");
                } else {
                    $this->redirect(URL_BASE   . "Composicao_tipo/edit/" . $composicao_tipo->composicao_tipo_id);
                }
            }
        }
    }

}
