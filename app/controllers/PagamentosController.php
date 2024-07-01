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

    public function index()
    {
        $dados["view"] = "Pagamentos/Show";
        $this->load("templateBootstrap", $dados);
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

        $pagamentos = new \stdClass();
        $pagamentos->pagador = $pagador;
        $pagamentos->recebedor = $recebedor;
        $pagamentos->valor = $valor;

        $dados["pagamentos"] = $pagamentos;
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

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
            0 => 'pagamentos_id',
            1 => 'pagador',
            2 => 'recebedor',
            3 => 'valor',
            4 => 'data'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = PagamentosService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = PagamentosService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->pagamentos_id;
            $registro[] = $coluna->pagador;
            $registro[] = $coluna->recebedor;
            $registro[] = $coluna->valor;
            $registro[] = $coluna->data;
            $registro[] = "<a href='" . URL_BASE . "Pagamentos/edit/" . $coluna->pagamentos_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->pagamentos_id . ")' type='button'
                class='btn btn-danger btn-sm mt-2' data-bs-toggle='modal'
                data-bs-target='#deleteModal'>
                Deletar
            </button>";
            $dados[] = $registro;
        }

        $resultado = [
            "draw" => intval($dados_requisicao['draw']),
            "recordsTotal" => $row_qnt_usuarios->total,
            "recordsFiltered" => $row_qnt_usuarios->total,
            "data" => $dados
        ];

        echo json_encode($resultado);
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
                    $pagamentos->pagador = $_POST["pagador"];
                if (isset($_POST["recebedor"]))
                    $pagamentos->recebedor = $_POST["recebedor"];
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
                    $this->redirect(URL_BASE . "Pagamentos");

                } else {
                    if (!$pagamentos->pagamentos_id) {
                        $this->redirect(URL_BASE . "Pagamentos/create");
                    } else {
                        $this->redirect(URL_BASE . "Pagamentos/edit/" . $pagamentos->pagamentos_id);
                    }
                }
            } catch (\Exception $e) {
                Flash::setMsg($e->getMessage());
                $this->redirect(URL_BASE . "Pagamentos");
                Service::rollback();
            }
        }
    }

}
