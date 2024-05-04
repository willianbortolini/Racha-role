<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\ProdutosService;
use app\core\Flash;
use app\models\service\Service;

class ProdutosController extends Controller
{
    private $tabela = "produtos";
    private $campo = "produtos_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["produtos"] = Service::get($this->tabela, 'he_produto_insumo', 0, true);
        $dados["view"] = "Produtos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function insumos()
    {
        $dados["produtos"] = Service::get($this->tabela, 'he_produto_insumo', 1, true);
        $dados["view"] = "Produtos/ShowInsumos";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($produtos_id)
    {
        $this->redirect(URL_BASE . 'Produtos/editar');
    }

    public function editar()
    {
        $produtos_id = $_COOKIE['parametro1'];
        $dados["produtos"] = Service::get($this->tabela, $this->campo, $produtos_id);
        $dados["produto_fotos"] = Service::get('produto_fotos', 'produtos_id', $produtos_id, true);
        $dados["tabela_preco"] = Service::lista('tabela_preco');
        $dados["view"] = "Produtos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $form = new \stdClass();
        if(Flash::getForm() == ''){
            $form->he_produto_final = 1;
        }else{
            $form = Flash::getForm();
        }
        $dados["produtos"] = $form;
        $dados["tabela_preco"] = Service::lista('tabela_preco');
        $dados["view"] = "Produtos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function createInsumo()
    {
        $form = new \stdClass();
        if(Flash::getForm() == ''){
            $form->he_produto_insumo = 1;
        }else{
            $form = Flash::getForm();
        }
        $dados["produtos"] = $form;
        $dados["tabela_preco"] = Service::lista('tabela_preco');
        $dados["view"] = "Produtos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function consultaEstoque()
    {
        $dados["produtos"] = ProdutosService::EstoqueInsumo();
        $dados["view"] = "Estoque/Consultar";
        $this->load("templateBootstrap", $dados);
    }

    public function editImagemOrcamento($produtos_id)
    {
        $produto = Service::get($this->tabela, $this->campo, $produtos_id);
        $dados["imagem"] = $produto->imagem_produto;
        $dados["produtos_id"] = $produtos_id;
        $dados["view"] = "Produtos/EditarImagensOrcamento";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                ProdutosService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function salvaOrcamento()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);

            if ($data['csrf_token'] !== $_SESSION['csrf_token']) {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'error' => 'Token CSRF inválido']);
                exit;
            }

            $produtos = new \stdClass();
            $produtos->produtos_id = $data["produtos_id"];
            $produtos->imagem_produto = $data["html"];

            if (ProdutosService::salvarImagemOrçamento($produtos, $this->campo, $this->tabela) > 1) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados']);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'error' => 'Método não permitido']);
        }
        exit;
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $produtos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["produtos_id"]) && is_numeric($_POST["produtos_id"]) && $_POST["produtos_id"] > 0) {
                    $produtos->produtos_id = $_POST["produtos_id"];
                } else {
                    $produtos->produtos_id = 0;
                }

                if (isset($_POST["produtos_nome"]))
                    $produtos->produtos_nome = $_POST["produtos_nome"];
                if (isset($_POST["produtos_descricao"]))
                    $produtos->produtos_descricao = $_POST["produtos_descricao"];
                if (isset($_POST["tabela_preco_id"]))
                    $produtos->tabela_preco_id = $_POST["tabela_preco_id"];
                if (isset($_POST["ordem"]))
                    $produtos->ordem = $_POST["ordem"];
                if (isset($_POST["descricao_os"]))
                    $produtos->descricao_os = $_POST["descricao_os"];
                if (isset($_POST["preco_medio"]))
                    $produtos->descricao_os = $_POST["preco_medio"];

                $produtos->he_produto_final = (isset($_POST["he_produto_final"])) ? 1 : 0;
                $produtos->he_produto_insumo = (isset($_POST["he_produto_insumo"])) ? 1 : 0;
                $produtos->produtos_usaTabelaPreco = ($produtos->tabela_preco_id == 0) ? 0 : 1;
            }

            Flash::setForm($produtos);
            if (ProdutosService::salvar($produtos) > 1) //se é maior que um inseriu novo 
            {
                if($produtos->he_produto_insumo == 1){
                    $this->redirect(URL_BASE . "Produtos/insumos");
                }else{
                    $this->redirect(URL_BASE . "Produtos");
                }
            } else {
                if (!$produtos->produtos_id) {
                    $this->redirect(URL_BASE . "Produtos/create");
                } else {
                    $this->redirect(URL_BASE . "Produtos/edit/" . $produtos->produtos_id);
                }
            }
        }
    }
}
