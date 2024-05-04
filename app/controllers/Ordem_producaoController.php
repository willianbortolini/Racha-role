<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Ordem_producaoService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\Op_item_posicaoService;
use Exception;
use GuzzleHttp\Psr7\Message;


class Ordem_producaoController extends Controller
{
    private $tabela = "ordem_producao";
    private $campo = "ordem_producao_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["ordem_producao"] = Service::lista($this->tabela);
        $dados["view"] = "Ordem_producao/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["ordem_producao"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Ordem_producao/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function pedidos_ordens_producao()
    {
        $dados["pedidos"] = Service::get('vw_pedidos', 'statusPedido_id', PEDIDO_APROVADO, true);
        $dados["view"] = "Ordem_producao/ShowPedidos";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["ordem_producao"] = Flash::getForm();
        $dados["view"] = "Ordem_producao/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function detalhe($ordem_producao)
    {
        $dados["ordem_producao"] = Service::get($this->tabela, $this->campo, $ordem_producao);
        $dados["ordem_producao_item"] = Service::get('vw_ordem_producao_item', 'ordem_producao_id', $ordem_producao, true);
        $dados["posicoes"] = Op_item_posicaoService::posicoesOrdenaras();
        $dados["posicaoItemOp"] = Ordem_producaoService::conteudoDaPosicaoDosItensNaOp($ordem_producao);
        $dados["reservasOp"] = Ordem_producaoService::produtosReservadosParaOP($ordem_producao);
        $dados["pedido"] = Service::get('vw_pedidos', 'pedidos_id', $dados["ordem_producao"]->pedidos_id);
        $dados["view"] = "Ordem_producao/DetalheOp";
        $this->load("template", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Ordem_producaoService::excluir($id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $ordem_producao = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["ordem_producao_id"]) && is_numeric($_POST["ordem_producao_id"]) && $_POST["ordem_producao_id"] > 0) {
                    $ordem_producao->ordem_producao_id = $_POST["ordem_producao_id"];
                } else {
                    $ordem_producao->ordem_producao_id = 0;
                }
                if (isset($_POST["ordem_producao_id"]))
                    $ordem_producao->ordem_producao_id = $_POST["ordem_producao_id"];
                if (isset($_POST["pedidos_id"]))
                    $ordem_producao->pedidos_id = $_POST["pedidos_id"];
                if (isset($_POST["empresa"]))
                    $ordem_producao->empresa = $_POST["empresa"];
                if (isset($_POST["data_criacao"]))
                    $ordem_producao->data_criacao = $_POST["data_criacao"];
                if (isset($_POST["data_inicio"]))
                    $ordem_producao->data_inicio = $_POST["data_inicio"];
                if (isset($_POST["data_finalizacao"]))
                    $ordem_producao->data_finalizacao = $_POST["data_finalizacao"];
                if (isset($_POST["operador"]))
                    $ordem_producao->operador = $_POST["operador"];
                if (isset($_POST["cliente"]))
                    $ordem_producao->cliente = $_POST["cliente"];
                if (isset($_POST["data_confirmacao_pedido"]))
                    $ordem_producao->data_confirmacao_pedido = $_POST["data_confirmacao_pedido"];
                if (isset($_POST["data_limite_producao"]))
                    $ordem_producao->data_limite_producao = $_POST["data_limite_producao"];
                if (isset($_POST["data_limite_instalcao"]))
                    $ordem_producao->data_limite_instalcao = $_POST["data_limite_instalcao"];


            }


            Flash::setForm($ordem_producao);
            if (Ordem_producaoService::salvar($ordem_producao) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Ordem_producao");
            } else {
                if (!$ordem_producao->ordem_producao_id) {
                    $this->redirect(URL_BASE . "Ordem_producao/create");
                } else {
                    $this->redirect(URL_BASE . "Ordem_producao/edit/" . $ordem_producao->ordem_producao_id);
                }
            }
        }
    }

    public function criarOsComPedido($pedido_id)
    {
        Service::begin_tran();
        try {
            Ordem_producaoService::criarOsComPedido($pedido_id);
            Service::commit();
        } catch (Exception $e) {
            Flash::setMsg("ERRO:". $e->getMessage(),-1);
            Service::rollBack();
        } finally {
            $this->redirect(URL_BASE . "ordem_producao/pedidos_ordens_producao");
        }
    }

    public function iniciar($ordem_producao_id)
    {
        $ordem_producao = new \stdClass();
        $ordem_producao->ordem_producao_id = $ordem_producao_id;
        $ordem_producao->data_inicio = date("Y-m-d H:i:s");
        $ordem_producao->operador = $_SESSION['id'];
        Ordem_producaoService::salvar($ordem_producao);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function finalizar($ordem_producao_id)
    {
        Service::begin_tran();
        try {
            Ordem_producaoService::Finaliza($ordem_producao_id);
            Service::commit();
        } catch (Exception $e) {
            Flash::setMsg("ERRO:". $e->getMessage(),-1);
            Service::rollBack();
        } finally {
           $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
