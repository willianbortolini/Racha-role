<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\ConvitesService;
use app\core\Flash;
use app\models\service\Service;

class ConvitesController extends Controller
{
    private $tabela = "convites";
    private $campo = "convites_id";
    private $view = "vw_convites";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["view"] = "Convites/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["convites"] = Service::get($this->view, $this->campo, $id);
        $dados["users"] = service::lista("users");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["view"] = "Convites/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["convites"] = Flash::getForm();
        $dados["users"] = service::lista("users");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["view"] = "Convites/Edit";
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
                ConvitesService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
         0 => 'convites_id',
         1 => 'usuario_id',
         2 => 'convidado_id',
         3 => 'email',
         4 => 'telefone',
         5 => 'status'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = ConvitesService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = ConvitesService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->convites_id;
            $registro[] = $coluna->usuario_id;
            $registro[] = $coluna->convidado_id;
            $registro[] = $coluna->email;
            $registro[] = $coluna->telefone;
            $registro[] = $coluna->status;
            $registro[] = "<a href='" . URL_BASE . "Convites/edit/" . $coluna->convites_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->convites_id . ")' type='button'
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
            $convites = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["convites_id"]) && is_numeric($_POST["convites_id"]) && $_POST["convites_id"] > 0) {                  
                    $convites->convites_id = $_POST["convites_id"];                    
                } else {
                    $convites->convites_id = 0;                         
                }
                if (isset($_POST["usuario_id"]))
                   $convites->usuario_id = $_POST["usuario_id"];
                if (isset($_POST["convidado_id"]))
                   $convites->convidado_id = $_POST["convidado_id"];
                if (isset($_POST["email"]))
                   $convites->email = $_POST["email"];
                if (isset($_POST["telefone"]))
                   $convites->telefone = $_POST["telefone"];
                if (isset($_POST["status"]))
                   $convites->status = $_POST["status"];
                if (isset($_POST["aceitado_em"]))
                   $convites->aceitado_em = $_POST["aceitado_em"];
                
               
            }


            Flash::setForm($convites);
            if (ConvitesService::salvar($convites) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Convites");
            } else {
                if (!$convites->convites_id) {
                    $this->redirect(URL_BASE   . "Convites/create");
                } else {
                    $this->redirect(URL_BASE   . "Convites/edit/" . $convites->convites_id);
                }
            }
        }
    }

}
