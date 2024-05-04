<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Posicao_opService;
use app\core\Flash;
use app\models\service\Service;

class Posicao_opController extends Controller
{
    private $tabela = "posicao_op";
    private $campo = "posicao_op_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["posicao_op"] = Service::lista($this->tabela);
        $dados["view"] = "Posicao_op/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["posicao_op"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Posicao_op/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["posicao_op"] = Flash::getForm();
        $dados["view"] = "Posicao_op/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Posicao_opService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $posicao_op = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["posicao_op_id"]) && is_numeric($_POST["posicao_op_id"]) && $_POST["posicao_op_id"] > 0) {
                    $posicao_op->posicao_op_id = $_POST["posicao_op_id"];
                } else {
                    $posicao_op->posicao_op_id = 0;
                }
                
                $posicao_op->ativo = (isset($_POST["ativo"])) ? '1' : '0';

                if (isset($_POST["descricao"]))
                    $posicao_op->descricao = $_POST["descricao"];
                if (isset($_POST["ordem"]))
                    $posicao_op->ordem = $_POST["ordem"];
            }

            Flash::setForm($posicao_op);
            if (Posicao_opService::salvar($posicao_op, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Posicao_op");
            } else {
                if (!$posicao_op->posicao_op_id) {
                    $this->redirect(URL_BASE . "Posicao_op/create");
                } else {
                    $this->redirect(URL_BASE . "Posicao_op/edit/" . $posicao_op->posicao_op_id);
                }
            }
        }
    }

}
