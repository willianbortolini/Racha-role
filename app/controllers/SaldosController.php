<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\SaldosService;
use app\core\Flash;
use app\models\service\Service;

class SaldosController extends Controller
{
    private $tabela = "saldos";
    private $campo = "saldos_id";
    private $view = "vw_saldos";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["view"] = "Saldos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["saldos"] = Service::get($this->view, $this->campo, $id);
        $dados["users"] = service::lista("users");
        $dados["view"] = "Saldos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["saldos"] = Flash::getForm();
        $dados["users"] = service::lista("users");
        $dados["view"] = "Saldos/Edit";
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
                SaldosService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
         0 => 'saldos_id',
         1 => 'devedor_id',
         2 => 'credor_id',
         3 => 'valor'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = SaldosService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = SaldosService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->saldos_id;
            $registro[] = $coluna->devedor_id;
            $registro[] = $coluna->credor_id;
            $registro[] = $coluna->valor;
            $registro[] = "<a href='" . URL_BASE . "Saldos/edit/" . $coluna->saldos_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->saldos_id . ")' type='button'
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
            $saldos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["saldos_id"]) && is_numeric($_POST["saldos_id"]) && $_POST["saldos_id"] > 0) {                  
                    $saldos->saldos_id = $_POST["saldos_id"];                    
                } else {
                    $saldos->saldos_id = 0;                         
                }
                if (isset($_POST["devedor_id"]))
                   $saldos->devedor_id = $_POST["devedor_id"];
                if (isset($_POST["credor_id"]))
                   $saldos->credor_id = $_POST["credor_id"];
                if (isset($_POST["valor"]))
                   $saldos->valor = $_POST["valor"];
                
               
            }


            Flash::setForm($saldos);
            if (SaldosService::salvar($saldos) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Saldos");
            } else {
                if (!$saldos->saldos_id) {
                    $this->redirect(URL_BASE   . "Saldos/create");
                } else {
                    $this->redirect(URL_BASE   . "Saldos/edit/" . $saldos->saldos_id);
                }
            }
        }
    }

}
