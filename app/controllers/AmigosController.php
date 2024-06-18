<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\AmigosService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\ConvitesService;

class AmigosController extends Controller
{
    private $tabela = "amigos";
    private $campo = "amigos_id";
    private $view = "vw_amigos";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["view"] = "Amigos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["amigos"] = Service::get($this->view, $this->campo, $id);
        $dados["users"] = service::lista("users");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["view"] = "Amigos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["amigos"] = Flash::getForm();
        $dados["users"] = service::lista("users");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["view"] = "Amigos/Edit";
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
                AmigosService::excluir($id);
            }
        }
    }

    public function list()
    {
        $dados_requisicao = $_REQUEST;

        // Lista de colunas da tabela
        $colunas = [
            0 => 'amigos_id',
            1 => 'usuario_id',
            2 => 'amigo_id',
            3 => 'status'
        ];

        if (!empty($dados_requisicao['search']['value'])) {
            $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        } else {
            $valor_pesquisa = "";
        }
        $row_qnt_usuarios = AmigosService::quantidadeDeLinhas($valor_pesquisa);

        $parametros = [
            'inicio' => intval($dados_requisicao['start']),
            'quantidade' => intval($dados_requisicao['length']),
            'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
            'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
            'valor_pesquisa' => $valor_pesquisa
        ];
        $listaRetorno = AmigosService::lista($parametros);
        $dados = [];
        foreach ($listaRetorno as $coluna) {
            $registro = [];
            $registro[] = $coluna->amigos_id;
            $registro[] = $coluna->usuario_id;
            $registro[] = $coluna->amigo_id;
            $registro[] = $coluna->status;
            $registro[] = "<a href='" . URL_BASE . "Amigos/edit/" . $coluna->amigos_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
            <button onclick='deletarItem(" . $coluna->amigos_id . ")' type='button'
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
            $amigos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["amigos_id"]) && is_numeric($_POST["amigos_id"]) && $_POST["amigos_id"] > 0) {
                    $amigos->amigos_id = $_POST["amigos_id"];
                } else {
                    $amigos->amigos_id = 0;
                }
                if (isset($_POST["usuario_id"]))
                    $amigos->usuario_id = $_POST["usuario_id"];
                if (isset($_POST["amigo_id"]))
                    $amigos->amigo_id = $_POST["amigo_id"];
                if (isset($_POST["status"]))
                    $amigos->status = $_POST["status"];


            }


            Flash::setForm($amigos);
            if (AmigosService::salvar($amigos) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Amigos");
            } else {
                if (!$amigos->amigos_id) {
                    $this->redirect(URL_BASE . "Amigos/create");
                } else {
                    $this->redirect(URL_BASE . "Amigos/edit/" . $amigos->amigos_id);
                }
            }
        }
    }

    public function convidar()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $amigo = Service::get('users', 'email', $_POST["email_amigo"]);
            if (!empty($amigo)) {
                $csrfToken = $_POST['csrf_token'];
                $convites = new \stdClass();
                $convites->convites_id = 0;
                $convites->usuario_id = $_SESSION['id'];
                $convites->convidado_id = $amigo->users_id;
                $convites->email = $_POST["email_amigo"];

                Flash::setForm($convites);
                //Service::begin_tran();
                try {
                    if (ConvitesService::salvar($convites) > 1) //se é maior que um inseriu novo 
                    {
                        Flash::setMsg('Convite enviado para o amigo', -1);
                        //Service::commit();
                    } else {
                        Flash::setMsg('Falha ao convidar amigo, tente novamente', -1);
                    }
                } catch (\Exception $e) {
                    i($e);
                    //Service::rollback();
                    //Flash::setMsg('Erro ao tentar enviar convite', -1);
                    $this->redirect(URL_BASE . "Amigos/create");
                    exit;
                }
            }
            $this->redirect(URL_BASE . "Amigos/create");

        } else {
            Flash::setMsg('E-mail enviado para o amigo', -1);
            $this->redirect(URL_BASE . "Amigos/create");
        }

    }



}
