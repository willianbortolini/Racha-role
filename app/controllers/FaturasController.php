<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\FaturasService;
use app\core\Flash;
use app\models\service\Service;

class FaturasController extends Controller
{
    private $tabela = "fi_faturas";
    private $campo = "fi_faturas_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["fi_faturas"] = Service::get('vw_fi_faturas', 'empresa', $_SESSION['id'], true);
        $dados["view"] = "Faturas/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["fornecedores"] = Service::get('usuarios', 'he_fornecedor', 1, true); 
        $dados["fi_faturas"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Faturas/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["fornecedores"] = Service::get('usuarios', 'he_fornecedor', 1, true); 
        $dados["fi_faturas"] = Flash::getForm();
        $dados["view"] = "Faturas/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function marcaPago($fi_faturas_id)
    {
        $faturas = new \stdClass();
        $faturas->fi_faturas_id = $fi_faturas_id;
        $faturas->data_pagamento = date("Y-m-d H:i:s");  
        FaturasService::salvar($faturas, $this->campo, $this->tabela);
        $this->redirect(URL_BASE . "Faturas");
    }
    public function desmarcaPago($fi_faturas_id)
    {
        $faturas = new \stdClass();
        $faturas->fi_faturas_id = $fi_faturas_id;
        $faturas->data_pagamento = null;  
        FaturasService::salvar($faturas, $this->campo, $this->tabela);
        $this->redirect(URL_BASE . "Faturas");
    }

    public function marcaCancelado($fi_faturas_id)
    {
        $faturas = new \stdClass();
        $faturas->fi_faturas_id = $fi_faturas_id;
        $faturas->data_cancelamento = date("Y-m-d H:i:s");  
        FaturasService::salvar($faturas, $this->campo, $this->tabela);
        $this->redirect(URL_BASE . "Faturas");
    }
    public function desmarcaCancelado($fi_faturas_id)
    {
        $faturas = new \stdClass();
        $faturas->fi_faturas_id = $fi_faturas_id;
        $faturas->data_cancelamento = null;  
        FaturasService::salvar($faturas, $this->campo, $this->tabela);
        $this->redirect(URL_BASE . "Faturas");
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];

                // Excluir
                FaturasService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $faturas = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["fi_faturas_id"]) && is_numeric($_POST["fi_faturas_id"]) && $_POST["fi_faturas_id"] > 0) {
                    $faturas->fi_faturas_id = $_POST["fi_faturas_id"];
                } else {
                    $faturas->fi_faturas_id = 0;
                }
                if (isset($_POST[" fornecedor"]))
                    $faturas-> fornecedor = $_POST[" fornecedor"];
                if (isset($_POST["data_emissao"]))
                    $faturas->data_emissao = $_POST["data_emissao"];
                if (isset($_POST["data_vencimento"]))
                    $faturas->data_vencimento = $_POST["data_vencimento"];
                if (isset($_POST["data_pagamento"]))
                    $faturas->data_pagamento = $_POST["data_pagamento"];
                if (isset($_POST["data_cancelamento	"]))
                    $faturas->data_cancelamento = $_POST["data_cancelamento	"];
                if (isset($_POST["valor_total"]))
                    $faturas->valor_total = $_POST["valor_total"];
                if (isset($_POST["descricao"]))
                    $faturas->descricao = $_POST["descricao"];
                if (isset($_POST["empresa"]))
                    $faturas->empresa = $_POST["empresa"];


            }


            Flash::setForm($faturas);
            if (FaturasService::salvar($faturas, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Faturas");
            } else {
                if (!$faturas->fi_faturas_id) {
                    $this->redirect(URL_BASE . "Faturas/create");
                } else {
                    $this->redirect(URL_BASE . "Faturas/edit/" . $faturas->fi_faturas_id);
                }
            }
        }
    }

}
