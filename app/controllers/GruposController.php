<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\GruposService;
use app\models\service\Usuarios_gruposService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\AmigosService;
use app\models\service\Participantes_despesasService;

class GruposController extends Controller
{
    private $tabela = "grupos";
    private $campo = "grupos_id";
    

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        
        $dados["view"] = "Grupos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function home()
    {
        $dados["minhasDespesas"] = Participantes_despesasService::meusValoresPorGrupo($_SESSION['id']);
        $dados["saldo"] = Participantes_despesasService::saldoUsuario($_SESSION['id']);
        $dados["btnAtivo"] = "grupos";
        $dados["view"] = "Grupos/home";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["grupos"] = Service::get($this->tabela, $this->campo, $id);
        $dados["membroGrupo"] = Usuarios_gruposService::membrosDoGrupo($id);
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);   
        $dados["view"] = "Grupos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["grupos"] = Flash::getForm();

        $dados["view"] = "Grupos/Edit";
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
                if (isset($existe_imagem->foto) && $existe_imagem->foto != '') {
                    UtilService::deletarImagens($existe_imagem->foto);
                }

                // Excluir
                GruposService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
         0 => 'grupos_id',
         1 => 'nome'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = GruposService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = GruposService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->grupos_id;
            $registro[] = $coluna->nome;
            $registro[] = "<a href='" . URL_BASE . "Grupos/edit/" . $coluna->grupos_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->grupos_id . ")' type='button'
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
            $grupos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["grupos_id"]) && is_numeric($_POST["grupos_id"]) && $_POST["grupos_id"] > 0) {                  
                    $grupos->grupos_id = $_POST["grupos_id"];                    
                } else {
                    $grupos->grupos_id = 0;                         
                }
                if (isset($_POST["nome"]))
                   $grupos->nome = $_POST["nome"];
                
               
            }


            Flash::setForm($grupos);
            if (GruposService::salvar($grupos) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Grupos");
            } else {
                if (!$grupos->grupos_id) {
                    $this->redirect(URL_BASE   . "Grupos/create");
                } else {
                    $this->redirect(URL_BASE   . "Grupos/edit/" . $grupos->grupos_id);
                }
            }
        }
    }

}
