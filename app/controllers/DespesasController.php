<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\DespesasService;
use app\models\service\Participantes_despesasService;
use app\models\service\GruposService;
use app\models\service\AmigosService;
use app\core\Flash;
use app\models\service\Service;

class DespesasController extends Controller
{
    private $tabela = "despesas";
    private $campo = "despesas_id";
    private $view = "vw_despesas";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["view"] = "Despesas/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function detalhe($user_id)
    {
        $dados["detalhe"] = Participantes_despesasService::negociacoesEntreDoisUsuarios($_SESSION['id'], $user_id);

        $dados["saldo"] = Participantes_despesasService::totalDividasEntreUsuarios($_SESSION['id'], $user_id);
        $dados["amigo"] = Service::get("users", "users_id",$user_id );
       
        $dados["view"] = "Despesas/DetalheUsuario";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["despesas"] = Service::get($this->view, $this->campo, $id);
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);        
        $dados["grupos"] = GruposService::gruposDoUsuario($_SESSION['id']);
        $dados["view"] = "Despesas/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["despesas"] = Flash::getForm();
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);
        $dados["grupos"] = GruposService::gruposDoUsuario($_SESSION['id']);
        $dados["view"] = "Despesas/Edit";
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
                DespesasService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
            0 => 'despesas_id',
            1 => 'descricao',
            2 => 'valor',
            3 => 'data',
            4 => 'users_id',
            5 => 'grupos_id'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = DespesasService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = DespesasService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->despesas_id;
            $registro[] = $coluna->descricao;
            $registro[] = $coluna->valor;
            $registro[] = $coluna->data;
            $registro[] = $coluna->users_id;
            $registro[] = $coluna->grupos_id;
            $registro[] = "<a href='" . URL_BASE . "Despesas/edit/" . $coluna->despesas_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->despesas_id . ")' type='button'
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
            $despesas = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["despesas_id"]) && is_numeric($_POST["despesas_id"]) && $_POST["despesas_id"] > 0) {
                    $despesas->despesas_id = $_POST["despesas_id"];
                } else {
                    $despesas->despesas_id = 0;
                }
                if (isset($_POST["descricao"]))
                    $despesas->descricao = $_POST["descricao"];
                if (isset($_POST["valor"]))
                    $despesas->valor = $_POST["valor"];
                if (isset($_POST["data"]))
                    $despesas->data = $_POST["data"];
                if (isset($_POST["users_id"]))
                    $despesas->users_id = $_POST["users_id"];
                if (isset($_POST["grupos_id"]))
                    $despesas->grupos_id = $_POST["grupos_id"];
                

            }
            $participantes = $_POST['participantes']; // Array de IDs de participantes
            $valorPorParticipante = $_POST['valorporparticipante']; // Array de IDs de participantes

            Flash::setForm($despesas);
            $despesa = DespesasService::salvar($despesas, $participantes, $valorPorParticipante);
            if ($despesa > 1) //se é maior que um inseriu novo 
            {               
                $this->redirect(URL_BASE);
            } else {
                if (!$despesas->despesas_id) {
                    $this->redirect(URL_BASE . "Despesas/create");
                } else {
                    $this->redirect(URL_BASE . "Despesas/edit/" . $despesas->despesas_id);
                }
            }
        }
    }

}
