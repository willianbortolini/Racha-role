<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Usuarios_gruposService;
use app\core\Flash;
use app\models\service\Service;

class Usuarios_gruposController extends Controller
{
    private $tabela = "usuarios_grupos";
    private $campo = "usuarios_grupos_id";
    private $view = "vw_usuarios_grupos";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["usuarios_grupos"] = Service::lista($this->view);
        $dados["view"] = "Usuarios_grupos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["usuarios_grupos"] = Service::get($this->view, $this->campo, $id);
        $dados["users"] = service::lista("users");
        $dados["grupos"] = service::lista("grupos");
        $dados["view"] = "Usuarios_grupos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["usuarios_grupos"] = Flash::getForm();
        $dados["users"] = service::lista("users");
        $dados["grupos"] = service::lista("grupos");
        $dados["view"] = "Usuarios_grupos/Edit";
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
                Usuarios_gruposService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
         0 => 'usuarios_grupos_id',
         1 => 'users_id',
         2 => 'grupos_id'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = Usuarios_gruposService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = Usuarios_gruposService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->usuarios_grupos_id;
            $registro[] = $coluna->users_id;
            $registro[] = $coluna->grupos_id;
            $registro[] = "<a href='" . URL_BASE . "Usuarios_grupos/edit/" . $coluna->usuarios_grupos_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->usuarios_grupos_id . ")' type='button'
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
            $usuarios_grupos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["usuarios_grupos_id"]) && is_numeric($_POST["usuarios_grupos_id"]) && $_POST["usuarios_grupos_id"] > 0) {                  
                    $usuarios_grupos->usuarios_grupos_id = $_POST["usuarios_grupos_id"];                    
                } else {
                    $usuarios_grupos->usuarios_grupos_id = 0;                         
                }
                if (isset($_POST["users_id"]))
                   $usuarios_grupos->users_id = $_POST["users_id"];
                if (isset($_POST["grupos_id"]))
                   $usuarios_grupos->grupos_id = $_POST["grupos_id"];
                
               
            }


            Flash::setForm($usuarios_grupos);
            if (Usuarios_gruposService::salvar($usuarios_grupos) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Usuarios_grupos");
            } else {
                if (!$usuarios_grupos->usuarios_grupos_id) {
                    $this->redirect(URL_BASE   . "Usuarios_grupos/create");
                } else {
                    $this->redirect(URL_BASE   . "Usuarios_grupos/edit/" . $usuarios_grupos->usuarios_grupos_id);
                }
            }
        }
    }

}
