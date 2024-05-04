<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Fi_transacoesService;
use app\core\Flash;
use app\models\service\Service;

class Fi_transacoesController extends Controller
{
    private $tabela = "fi_transacoes";
    private $campo = "fi_transacoes_id";
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
        $dados["fi_transacoes"] = Service::get('vw_fi_transacoes', 'usuarios_id', $_SESSION['id'], true);
        $dados["gastoSemanal"] = Fi_transacoesService::gastoSemanal($_SESSION['id']);
        $dados["gastoPorCategoriaSemanal"] = Fi_transacoesService::gastoPorCategoriaSemanal($_SESSION['id']);
        $dados["gastoMensal"] = Fi_transacoesService::gastoMensal($_SESSION['id']);
        $dados["gastoPorCategoriaMensal"] = Fi_transacoesService::gastoPorCategoriaMes($_SESSION['id']);
        $dados["view"] = "Fi_transacoes/Geral";
        $this->load("templateBootstrap", $dados);
    }

    public function show()
    {
        $dados["fi_transacoes"] = Service::get('vw_fi_transacoes', 'usuarios_id', $_SESSION['id'], true);
        $dados["view"] = "Fi_transacoes/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function categoriaSemana($id_categoria)
    {
        $dados["fi_transacoes"] = Fi_transacoesService::CategoriaSemana($_SESSION['id'],$id_categoria);
        $dados["view"] = "Fi_transacoes/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function categoriaMes($id_categoria)
    {
        $dados["fi_transacoes"] = Fi_transacoesService::CategoriaMes($_SESSION['id'],$id_categoria);
        $dados["view"] = "Fi_transacoes/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["fi_transacoes"] = Service::get($this->tabela, $this->campo, $id);
        $dados["fi_conta"] = Service::get('fi_conta', 'usuarios_id', $_SESSION['id'], true);
        $dados["fi_categorias"] = Service::get('fi_categorias', 'usuarios_id', $_SESSION['id'], true);
        $dados["fi_meio"] = Service::lista('fi_meio');
        $dados["view"] = "Fi_transacoes/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["fi_transacoes"] = Flash::getForm();
        $dados["fi_conta"] = Service::get('fi_conta', 'usuarios_id', $_SESSION['id'], true);
        $dados["fi_categorias"] = Service::get('fi_categorias', 'usuarios_id', $_SESSION['id'], true);
        $dados["fi_meio"] = Service::lista('fi_meio');
        $dados["view"] = "Fi_transacoes/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Fi_transacoesService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $fi_transacoes = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["fi_transacoes_id"]) && is_numeric($_POST["fi_transacoes_id"]) && $_POST["fi_transacoes_id"] > 0) {
                    $fi_transacoes->fi_transacoes_id = $_POST["fi_transacoes_id"];
                } else {
                    $fi_transacoes->fi_transacoes_id = 0;
                }
                if (isset($_POST["tipo"]))
                    $fi_transacoes->tipo = $_POST["tipo"];
                if (isset($_POST["usuarios_id"])) {
                    $fi_transacoes->usuarios_id = $_POST["usuarios_id"];
                } else {
                    $fi_transacoes->usuarios_id = $_SESSION['id'];
                }
                if (isset($_POST["valor"]))
                    $fi_transacoes->valor = $_POST["valor"];
                if (isset($_POST["data"]))
                    $fi_transacoes->data = $_POST["data"];

                if (isset($_POST["data"]))
                    $fi_transacoes->data_pagamento = $_POST["data"];
                /*if (isset($_POST["data_pagamento"]))
                    $fi_transacoes->data_pagamento = $_POST["data_pagamento"];*/

                if (isset($_POST["descricao"]))
                    $fi_transacoes->descricao = $_POST["descricao"];
                if (isset($_POST["fi_categorias_id"]))
                    $fi_transacoes->fi_categorias_id = $_POST["fi_categorias_id"];
                if (isset($_POST["numero_parcelas"]))
                    $fi_transacoes->numero_parcelas = $_POST["numero_parcelas"];
                if (isset($_POST["parcela_atual"]))
                    $fi_transacoes->parcela_atual = $_POST["parcela_atual"];
                if (isset($_POST["fi_conta_id"]))
                    $fi_transacoes->fi_conta_id = $_POST["fi_conta_id"];
                if (isset($_POST["fi_meio_id"]))
                    $fi_transacoes->fi_meio_id = $_POST["fi_meio_id"];
                
                $fi_transacoes->custo_fixo = (isset($_POST['custo_fixo']) && $_POST['custo_fixo'] == 'on') ? 1 : 0;


            }


            Flash::setForm($fi_transacoes);
            if (Fi_transacoesService::salvar($fi_transacoes, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Fi_transacoes");
            } else {
                if (!$fi_transacoes->fi_transacoes_id) {
                    $this->redirect(URL_BASE . "Fi_transacoes/create");
                } else {
                    $this->redirect(URL_BASE . "Fi_transacoes/edit/" . $fi_transacoes->fi_transacoes_id);
                }
            }
        }
    }

}
