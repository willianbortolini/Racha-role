<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\StatusPedidoService;
use app\core\Flash;
use app\models\service\Service;

class StatusPedidoController extends Controller
{
    private $tabela = "statusPedido";
    private $campo = "statusPedido_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["statusPedido"] = Service::lista($this->tabela);
        $dados["view"] = "StatusPedido/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["statusPedido"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "StatusPedido/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["statusPedido"] = Flash::getForm();
        $dados["view"] = "StatusPedido/Edit";
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
                StatusPedidoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $statusPedido = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["statusPedido_id"]) && is_numeric($_POST["statusPedido_id"]) && $_POST["statusPedido_id"] > 0) {                  
                    $statusPedido->statusPedido_id = $_POST["statusPedido_id"];                    
                } else {
                    $statusPedido->statusPedido_id = 0;                         
                }
                                if (isset($_POST["statusPedido_nome"]))
                   $statusPedido->statusPedido_nome = $_POST["statusPedido_nome"];
                
               
            }


            Flash::setForm($statusPedido);
            if (StatusPedidoService::salvar($statusPedido, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "StatusPedido");
            } else {
                if (!$statusPedido->statusPedido_id) {
                    $this->redirect(URL_BASE   . "StatusPedido/create");
                } else {
                    $this->redirect(URL_BASE   . "StatusPedido/edit/" . $statusPedido->statusPedido_id);
                }
            }
        }
    }

}
