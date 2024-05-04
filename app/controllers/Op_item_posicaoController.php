<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Op_item_posicaoService;
use app\core\Flash;
use app\models\service\Service;

class Op_item_posicaoController extends Controller
{
    private $tabela = "op_item_posicao";
    private $campo = "op_item_posicao_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["op_item_posicao"] = Service::lista($this->tabela);
        $dados["view"] = "Op_item_posicao/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["op_item_posicao"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Op_item_posicao/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["op_item_posicao"] = Flash::getForm();
        $dados["view"] = "Op_item_posicao/Edit";
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
                Op_item_posicaoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $op_item_posicao = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["op_item_posicao_id"]) && is_numeric($_POST["op_item_posicao_id"]) && $_POST["op_item_posicao_id"] > 0) {
                    $op_item_posicao->op_item_posicao_id = $_POST["op_item_posicao_id"];
                } else {
                    $op_item_posicao->op_item_posicao_id = 0;
                }
                if (isset($_POST["posicao_op_id"]))
                    $op_item_posicao->posicao_op_id = $_POST["posicao_op_id"];
                if (isset($_POST["ordem_producao_item_id"]))
                    $op_item_posicao->ordem_producao_item_id = $_POST["ordem_producao_item_id"];
                if (isset($_POST["conteudo_op_item"]))
                    $op_item_posicao->conteudo_op_item = $_POST["conteudo_op_item"];


            }


            Flash::setForm($op_item_posicao);
            if (Op_item_posicaoService::salvar($op_item_posicao, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Op_item_posicao");
            } else {
                if (!$op_item_posicao->op_item_posicao_id) {
                    $this->redirect(URL_BASE . "Op_item_posicao/create");
                } else {
                    $this->redirect(URL_BASE . "Op_item_posicao/edit/" . $op_item_posicao->op_item_posicao_id);
                }
            }
        }
    }

}
