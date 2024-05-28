<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\TicketsService;
use app\core\Flash;
use app\models\service\Service;

class TicketsController extends Controller
{
    private $tabela = "tickets";
    private $campo = "tickets_id";
    private $view = "vw_tickets";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["tickets"] = Service::lista($this->view);
        $dados["view"] = "Tickets/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["tickets"] = Service::get($this->view, $this->campo, $id);
        $dados["usuarios"] = service::lista("usuarios");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["priority"] = service::getEnumValues($this->tabela, "priority");
        $dados["view"] = "Tickets/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["tickets"] = Flash::getForm();
        $dados["usuarios"] = service::lista("usuarios");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["priority"] = service::getEnumValues($this->tabela, "priority");
        $dados["view"] = "Tickets/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                
                // Excluir a imagem, se existir               
                $existe_imagem = service::get($this->tabela, $this->campo, $id);
                if (isset($existe_imagem->imagem_perfil) && $existe_imagem->imagem_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->imagem_perfil);
                }

                // Excluir
                TicketsService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
         0 => 'tickets_id',
         1 => 'user_id',
         2 => 'subject',
         3 => 'CPF',
         4 => 'status',
         5 => 'priority'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = TicketsService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = TicketsService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->tickets_id;
            $registro[] = $coluna->user_id;
            $registro[] = $coluna->subject;
            $registro[] = $coluna->CPF;
            $registro[] = $coluna->status;
            $registro[] = $coluna->priority;
            $registro[] = "<a href='" . URL_BASE . "User/edit/" . $coluna->tickets_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->tickets_id . ")' type='button'
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
            $tickets = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["tickets_id"]) && is_numeric($_POST["tickets_id"]) && $_POST["tickets_id"] > 0) {                  
                    $tickets->tickets_id = $_POST["tickets_id"];                    
                } else {
                    $tickets->tickets_id = 0;                         
                }
                if (isset($_POST["user_id"]))
                   $tickets->user_id = $_POST["user_id"];
                if (isset($_POST["subject"]))
                   $tickets->subject = $_POST["subject"];
                if (isset($_POST["description"]))
                   $tickets->description = $_POST["description"];
                if (isset($_POST["CPF"]))
                   $tickets->CPF = $_POST["CPF"];
                if (isset($_POST["status"]))
                   $tickets->status = $_POST["status"];
                if (isset($_POST["priority"]))
                   $tickets->priority = $_POST["priority"];
                
               
            }


            Flash::setForm($tickets);
            if (TicketsService::salvar($tickets) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Tickets");
            } else {
                if (!$tickets->tickets_id) {
                    $this->redirect(URL_BASE   . "Tickets/create");
                } else {
                    $this->redirect(URL_BASE   . "Tickets/edit/" . $tickets->tickets_id);
                }
            }
        }
    }

}
