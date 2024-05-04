<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\models\service\PedidoService;
use app\core\Flash;
use app\util\UtilService;

class HomeController extends Controller
{
    public function __construct()
    {
        $usuario = UtilService::getUsuario();
        if (!$usuario) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function index()
    {
        if (isset($_SESSION['he_administrador'])) {
            $habilitado = 1;
            $dados["orcamentos"] = Service::get('vw_pedidos', 'statusPedido_id', ORCAMENTO, true);
            $dados["pedidos"] = Service::getGeral('vw_pedidos', 'statusPedido_id', ' > ', ORCAMENTO, true);
            $dados["view"] = "Home/Administrador";
        } else if (isset($_SESSION['he_representante'])) {
            $habilitado = Service::get('usuarios', 'usuarios_id', $_SESSION['id'])->habilitado;
            if ($habilitado) {
                $dados["orcamentos"] = PedidoService::listaOrcamentoRepresentante();
                $dados["pedidos"] = PedidoService::listaPedidoRepresentante();
            } else {
                $dados["orcamentos"] = [];
                $dados["pedidos"] = [];
            }
            $dados["habilitado"] = $habilitado;
            $dados["view"] = "Home/Representante";
        }else if (isset($_SESSION['he_colaborador'])) {
            $dados["view"] = "Home/HomeVazia";
        }else if (isset($_SESSION['he_master'])) {
            $this->redirect(URL_BASE . "Fi_transacoes");
        } else {
            $dados["view"] = "login";
        }
        $this->load("templateBootstrap", $dados);
    }

    public function DashboardAdministrador()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["orcamentos"] = Service::get('vw_pedidos', 'statusPedido_id', ORCAMENTO, true);
        $ultimoDiaMesAnterior = date("Y-m-d", strtotime("last day of previous month"));
        $dados["orcamentosDoMes"] = Service::getGeral('vw_pedidos', 'pedido_dataCriacao', ' >', $ultimoDiaMesAnterior, true);
        $dados["pedidosDoMes"] = Service::getGeral('vw_pedidos', 'data_pedido', ' >', $ultimoDiaMesAnterior, true);
        $dados["pedidos"] = Service::getGeral('vw_pedidos', 'statusPedido_id', ' > ', ORCAMENTO, true);
        $dados["view"] = "Home/DashboardAdministrador";
        $this->load("templateBootstrap", $dados);
    }
    public function PoliticasDePrivacidade()
    {
        $dados["view"] = "PoliticaPrivacidade/politicaprivacidade";
        $this->load("templateBootstrap", $dados);
    }
}
