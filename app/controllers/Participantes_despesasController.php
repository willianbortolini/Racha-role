<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Participantes_despesasService;
use app\core\Flash;
use app\models\service\Service;

class Participantes_despesasController extends Controller
{
    private $tabela = "participantes_despesas";
    private $campo = "participantes_despesas_id";
    private $view = "vw_participantes_despesas";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["view"] = "Participantes_despesas/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["participantes_despesas"] = Service::get($this->view, $this->campo, $id);
        $dados["despesas"] = service::lista("despesas");
        $dados["users"] = service::lista("users");
        $dados["view"] = "Participantes_despesas/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["participantes_despesas"] = Flash::getForm();
        $dados["despesas"] = service::lista("despesas");
        $dados["users"] = service::lista("users");
        $dados["view"] = "Participantes_despesas/Edit";
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
                Participantes_despesasService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
         0 => 'participantes_despesas_id',
         1 => 'despesas_id',
         2 => 'users_id',
         3 => 'valor'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = Participantes_despesasService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = Participantes_despesasService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->participantes_despesas_id;
            $registro[] = $coluna->despesas_id;
            $registro[] = $coluna->users_id;
            $registro[] = $coluna->valor;
            $registro[] = "<a href='" . URL_BASE . "Participantes_despesas/edit/" . $coluna->participantes_despesas_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->participantes_despesas_id . ")' type='button'
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
            $participantes_despesas = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["participantes_despesas_id"]) && is_numeric($_POST["participantes_despesas_id"]) && $_POST["participantes_despesas_id"] > 0) {                  
                    $participantes_despesas->participantes_despesas_id = $_POST["participantes_despesas_id"];                    
                } else {
                    $participantes_despesas->participantes_despesas_id = 0;                         
                }
                if (isset($_POST["despesas_id"]))
                   $participantes_despesas->despesas_id = $_POST["despesas_id"];
                if (isset($_POST["users_id"]))
                   $participantes_despesas->users_id = $_POST["users_id"];
                if (isset($_POST["valor"]))
                   $participantes_despesas->valor = $_POST["valor"];
                
               
            }


            Flash::setForm($participantes_despesas);
            if (Participantes_despesasService::salvar($participantes_despesas) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Participantes_despesas");
            } else {
                if (!$participantes_despesas->participantes_despesas_id) {
                    $this->redirect(URL_BASE   . "Participantes_despesas/create");
                } else {
                    $this->redirect(URL_BASE   . "Participantes_despesas/edit/" . $participantes_despesas->participantes_despesas_id);
                }
            }
        }
    }

}
