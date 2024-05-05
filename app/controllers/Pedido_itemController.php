<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Pedido_itemService;
use app\models\service\ProdutosService;
use app\core\Flash;
use app\models\service\Service;

class Pedido_itemController extends Controller
{
    private $tabela = "pedido_item";
    private $campo = "pedido_item_id";
    private $usuario;

    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function index($pedidos_id)
    {
        $dados["pedido_item"] = Service::get($this->tabela, 'pedidos_id', $pedidos_id, true);
        $dados["view"] = "Pedido_item/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function pedido($pedidos_id)
    {
        $dados["pedidos_id"] = $pedidos_id;
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $pedidos_id, true);
        $dados["view"] = "Pedido_item/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["pedido_item_composicao"] = Service::get("pedido_item_composicao", "pedido_item_id", $id, true, 'asc');
        $dados["produtos"] = ProdutosService::produtosOrdenados();
        $dados["pedido_item"] = Service::get('vw_pedido_item', $this->campo, $id);
        $dados["produto_fotos"] = Service::get('produto_fotos', 'produtos_id', 1, true);
        $dados["foto_item_pedido"] = Service::get('foto_item_pedido', 'pedido_item_id', $dados["pedido_item"]->pedido_item_id, true);
        $dados["view"] = "Pedido_item/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function produto_fotos($id)
    {
        Service::get('produto_fotos', 'produtos_id', $id, true);
    }

    public function create($pedidos_id)
    {
        $dados["pedidos_id"] = $pedidos_id;
        $dados["pedido_item_composicao"] = [];
        $dados["produtos"] = Service::lista("produtos");
        $dados["pedido_item"] = Flash::getForm();
        $dados["view"] = "Pedido_item/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Pedido_itemService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {

        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $pedido_item = new \stdClass();

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["pedido_item_id"]) && is_numeric($_POST["pedido_item_id"]) && $_POST["pedido_item_id"] > 0) {
                    $pedido_item->pedido_item_id = $_POST["pedido_item_id"];
                } else {
                    $pedido_item->pedido_item_id = 0;
                }
                if (isset($_POST["pedidos_id"]))
                    $pedido_item->pedidos_id = $_POST["pedidos_id"];
                if (isset($_POST["pedido_item_largura"]))
                    $pedido_item->pedido_item_largura = $_POST["pedido_item_largura"];
                if (isset($_POST["pedido_item_altura"]))
                    $pedido_item->pedido_item_altura = $_POST["pedido_item_altura"];
                if (isset($_POST["pedido_item_quantidade"]))
                    $pedido_item->pedido_item_quantidade = $_POST["pedido_item_quantidade"];
                if (isset($_POST["produtos_id"]))
                    $pedido_item->produtos_id = $_POST["produtos_id"];
                if (isset($_POST["pedido_item_valor_unitario"]))
                    $pedido_item->pedido_item_valor_unitario = $_POST["pedido_item_valor_unitario"];
                if (isset($_POST["pedido_item_valor_opcionais"]))
                    $pedido_item->pedido_item_valor_opcionais = $_POST["pedido_item_valor_opcionais"];
                if (isset($_POST["pedido_item_valor_total"]))
                    $pedido_item->pedido_item_valor_total = $_POST["pedido_item_valor_total"];
                if (isset($_POST["pedido_item_descricao"]))
                    $pedido_item->pedido_item_descricao = $_POST["pedido_item_descricao"];
                if (isset($_POST["pedido_item_markup"]))
                    $pedido_item->pedido_item_markup = $_POST["pedido_item_markup"];

                $pedido_item->pedido_item_composicao_descricao = Service::get('vw_pedido_item', 'pedido_item_id', $pedido_item->pedido_item_id)->composicoes;

                Flash::setForm($pedido_item);

                $alturaArredondada = floor((int) $pedido_item->pedido_item_altura / 10) * 10;
                $larguraArredondada = floor((int) $pedido_item->pedido_item_largura / 10) * 10;

                $tabelaDoProduto = Service::get('produtos', 'produtos_id', $pedido_item->produtos_id);
                $tabelaDePreco = Service::get('tabela_preco_item', 'tabela_preco_id', $tabelaDoProduto->tabela_preco_id, true);

                // Obtendo os valores mínimos da tabela
                if (count($tabelaDePreco) > 0) {
                    $larguraMinima = min(array_column($tabelaDePreco, 'largura'));
                    $alturaMinima = min(array_column($tabelaDePreco, 'altura'));
                }
                if ($alturaArredondada < $alturaMinima) {
                    $alturaArredondada = $alturaMinima;
                }

                if ($larguraArredondada < $larguraMinima) {
                    $larguraArredondada = $larguraMinima;
                }

                foreach ($tabelaDePreco as $item) {
                    if ($item->altura == $alturaArredondada && $item->largura == $larguraArredondada) {
                        $valorUnitario = $item->valor;
                    }
                }

                if (($valorUnitario != $pedido_item->pedido_item_valor_unitario) && ($pedido_item->pedido_item_valor_unitario > 0)) {
                    Flash::setMsg("Erro ao calcular o valor unitário de tabela, caso o problema persistir contate o suporte.", -1);
                    $this->redirect(URL_BASE . "Pedido_item/edit/" . $pedido_item->pedido_item_id);
                }

                if ($pedido_item->pedido_item_valor_total > 0) {
                    if (number_format((($tabelaDoProduto->preco_medio + $pedido_item->pedido_item_valor_unitario + $pedido_item->pedido_item_valor_opcionais) * $pedido_item->pedido_item_quantidade), 2, '.', '') != $pedido_item->pedido_item_valor_total) {
                        Flash::setMsg("Erro ao calcular o valor total, caso o problema persistir contate o suporte.", -1);
                        $this->redirect(URL_BASE . "Pedido_item/edit/" . $pedido_item->pedido_item_id);
                    }
                }


                $pedido_item_id = Pedido_itemService::salvar($pedido_item, $this->campo, $this->tabela);
                if ($pedido_item_id > 1) //se é maior que um inseriu novo 
                {
                    $this->redirect(URL_BASE . "Pedido_item/edit/" . $pedido_item_id);
                } else {
                    if (!$pedido_item->pedido_item_id) {
                        $this->redirect(URL_BASE . "Pedido_item/pedido/" . $pedido_item->pedidos_id);
                    } else {
                        $this->redirect(URL_BASE . "Pedido_item/edit/" . $pedido_item->pedido_item_id);
                    }
                }
            }
        }
    }
}
