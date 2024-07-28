<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\PagamentosService;
use app\models\service\AmigosService;
use app\models\service\Participantes_despesasService;
use app\models\service\DespesasService;

use app\core\Flash;
use app\models\service\Service;

class PagamentosController extends Controller
{
    private $tabela = "pagamentos";
    private $campo = "pagamentos_id";
    private $view = "vw_pagamentos";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function edit($id)
    {
        $dados["pagamentos"] = Service::get($this->view, $this->campo, $id);
        $dados["users"] = service::lista("users");
        $dados["view"] = "Pagamentos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function quitar($valor, $pagador, $recebedor)
    {
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);
        $dados["pagador"] = Service::get('users', 'users_uid', $pagador);
        $dados["recebedor"] = Service::get('users', 'users_uid', $recebedor);
        $dados["valor"] = abs($valor);
        $dados["view"] = "Pagamentos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["pagamentos"] = Flash::getForm();
        $dados["users"] = service::lista("users");
        $dados["view"] = "Pagamentos/Edit";
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
                PagamentosService::excluir($id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $pagamentos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["pagamentos_id"]) && is_numeric($_POST["pagamentos_id"]) && $_POST["pagamentos_id"] > 0) {
                    $pagamentos->pagamentos_id = $_POST["pagamentos_id"];
                } else {
                    $pagamentos->pagamentos_id = 0;
                }
                if (isset($_POST["pagador"]))
                    $pagamentos->pagador = Service::getUsers_idComUid($_POST["pagador"]);
                if (isset($_POST["recebedor"]))
                    $pagamentos->recebedor = Service::getUsers_idComUid($_POST["recebedor"]);
                if (isset($_POST["valor"]))
                    $pagamentos->valor = $_POST["valor"];
                if (isset($_POST["data"]))
                    $pagamentos->data = $_POST["data"];
            }
            Flash::setForm($pagamentos);

            Service::begin_tran();

            try {

                $pagamentos_id = PagamentosService::salvar($pagamentos); //se é maior que um inseriu novo 
                if ($pagamentos_id > 1) //se é maior que um inseriu novo 
                {

                    Service::commit();
                    $this->redirect(URL_BASE);

                } else {
                    $this->redirect(URL_BASE . "Pagamentos/create");
                }
            } catch (\Exception $e) {
                Flash::setMsg($e->getMessage());
                $this->redirect(URL_BASE . "Pagamentos/create");
                Service::rollback();
            }
        }
    }

}
