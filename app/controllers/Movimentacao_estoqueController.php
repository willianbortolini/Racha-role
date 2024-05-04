<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Movimentacao_estoqueService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\ProdutosService;

class Movimentacao_estoqueController extends Controller
{
    private $tabela = "movimentacao_estoque";
    private $campo = "movimentacao_estoque_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $this->redirect(URL_BASE . "Movimentacao_estoque/pesquisar");
    }

    public function edit($id)
    {
        $dados["movimentacao_estoque"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Movimentacao_estoque/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function MovimentacaoManual()
    {
        $dados["produtos"] = ProdutosService::EstoqueInsumo();
        $dados["view"] = "Movimentacao_estoque/MovimentacaoManual";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {

        $dados["pesquisa"] = Flash::getForm();
        $dados["view"] = "Movimentacao_estoque/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function pesquisar()
    {
        $pesquisa = new \stdClass();
        if (isset($_POST["produtos_id"]))
            $pesquisa->produtos_id = $_POST["produtos_id"];
        if (isset($_POST["dataInicio"]))
            $pesquisa->dataInicio = $_POST["dataInicio"];
        if (isset($_POST["dataFim"]))
            $pesquisa->dataFim = $_POST["dataFim"];
        $pesquisa->he_entrada = (isset($_POST["he_entrada"])) ? 1 : 0;
        $pesquisa->he_saida = (isset($_POST["he_saida"])) ? 1 : 0;
        $pesquisa->he_reserva = (isset($_POST["he_reserva"])) ? 1 : 0;
        
        if (isset($pesquisa->produtos_id)) {
            $dados["intesPesquisados"] = Movimentacao_estoqueService::pesquisa(clone $pesquisa);
        }
        $dados["produtos"] = ProdutosService::EstoqueInsumo();
        $dados["pesquisa"] = $pesquisa;
        $dados["view"] = "Movimentacao_estoque/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Movimentacao_estoqueService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $movimentacao_estoque = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["movimentacao_estoque_id"]) && is_numeric($_POST["movimentacao_estoque_id"]) && $_POST["movimentacao_estoque_id"] > 0) {
                    $movimentacao_estoque->movimentacao_estoque_id = $_POST["movimentacao_estoque_id"];
                } else {
                    $movimentacao_estoque->movimentacao_estoque_id = 0;
                }
                if (isset($_POST["produtos_id"]))
                    $movimentacao_estoque->produtos_id = $_POST["produtos_id"];
                if (isset($_POST["quantidade"]))
                    $movimentacao_estoque->quantidade = $_POST["quantidade"];
                if (isset($_POST["tipo_movimentacao"]))
                    $movimentacao_estoque->tipo_movimentacao = $_POST["tipo_movimentacao"];
                if (isset($_POST["descricao"]))
                    $movimentacao_estoque->descricao = $_POST["descricao"];
                if (isset($_POST["data"]))
                    $movimentacao_estoque->data = $_POST["data"];
                if (isset($_POST["usuarios_id"]))
                    $movimentacao_estoque->usuarios_id = $_POST["usuarios_id"];
                if (isset($_POST["reserva_id"]))
                    $movimentacao_estoque->reserva_id = $_POST["reserva_id"];
            }
            Flash::setForm($movimentacao_estoque);
            if (Movimentacao_estoqueService::salvar($movimentacao_estoque, ) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Movimentacao_estoque");
            } else {
                if (!$movimentacao_estoque->movimentacao_estoque_id) {
                    $this->redirect(URL_BASE . "Movimentacao_estoque/create");
                } else {
                    $this->redirect(URL_BASE . "Movimentacao_estoque/edit/" . $movimentacao_estoque->movimentacao_estoque_id);
                }
            }
        }
    }

    public function saveMovimentacaoManual()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $produtos_id = $_POST["produtos_id"];
            $quantidade = $_POST["quantidade"];
            $descricao = $_POST["descricao"];
            $tipo_movimentacao = $_POST["tipo_movimentacao"];
            $reserva = $_POST["reserva"];

            switch ($tipo_movimentacao) {
                case MOVIMENTACAO_ENTRADA:
                    Movimentacao_estoqueService::entradaEstoque($produtos_id, $quantidade, $reserva, $descricao);
                    break;
                case MOVIMENTACAO_SAIDA:
                    Movimentacao_estoqueService::saidaEstoque($produtos_id, $quantidade, $reserva);
                    break;
                default:
                    break;
            }
        }
        $this->redirect(URL_BASE . "Movimentacao_estoque/MovimentacaoManual");
    }

}
