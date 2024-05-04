<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Tabela_preco_itemService;
use app\core\Flash;
use app\models\service\Service;

class Tabela_preco_itemController extends Controller
{
    private $tabela = "tabela_preco_item";
    private $campo = "tabela_preco_item_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function index()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["tabela_preco_item"] = Service::lista($this->tabela);
        $dados["view"] = "Tabela_preco_item/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["tabela_preco_item"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Tabela_preco_item/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["tabela_preco_item"] = Flash::getForm();
        $dados["view"] = "Tabela_preco_item/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function tabela($produtos_id)
    {
        $tabelaDoProduto = Service::get('produtos', 'produtos_id', $produtos_id);
        if ($tabelaDoProduto && property_exists($tabelaDoProduto, 'tabela_preco_id')) {
            $resultado = Service::get($this->tabela, 'tabela_preco_id', $tabelaDoProduto->tabela_preco_id, true);
            echo json_encode($resultado);
        } else {
            echo json_encode(['error' => 'não existe tabela para esse produto']);
        }
    }

    public function delete()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                // Excluir
                Tabela_preco_itemService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $tabela_preco_item = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["tabela_preco_item_id"]) && is_numeric($_POST["tabela_preco_item_id"]) && $_POST["tabela_preco_item_id"] > 0) {
                    $tabela_preco_item->tabela_preco_item_id = $_POST["tabela_preco_item_id"];
                } else {
                    $tabela_preco_item->tabela_preco_item_id = 0;
                }
                if (isset($_POST["tabela_preco_id"]))
                    $tabela_preco_item->tabela_preco_id = $_POST["tabela_preco_id"];
                if (isset($_POST["largura"]))
                    $tabela_preco_item->largura = $_POST["largura"];
                if (isset($_POST["altura"]))
                    $tabela_preco_item->altura = $_POST["altura"];
                if (isset($_POST["valor"]))
                    $tabela_preco_item->valor = $_POST["valor"];

            }


            Flash::setForm($tabela_preco_item);
            if (Tabela_preco_itemService::salvar($tabela_preco_item, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Tabela_preco_item");
            } else {
                if (!$tabela_preco_item->tabela_preco_item_id) {
                    $this->redirect(URL_BASE . "Tabela_preco_item/create");
                } else {
                    $this->redirect(URL_BASE . "Tabela_preco_item/edit/" . $tabela_preco_item->tabela_preco_item_id);
                }
            }
        }
    }

    public function saveJson($tabela_preco_id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Recebe os dados do JSON enviado pelo JavaScript

            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);
            $erros = [];
            Tabela_preco_itemService::excluir($this->tabela, 'tabela_preco_id', $tabela_preco_id);

            foreach ($data as $item) {
                $tabela_preco_item = new \stdClass();
                $tabela_preco_item->tabela_preco_id = $tabela_preco_id;
                $tabela_preco_item->largura = $item['largura'] ?? null;
                $tabela_preco_item->altura = $item['altura'] ?? null;
                $tabela_preco_item->valor = $item['valor'] ?? null;
                $tabela_preco_item->tabela_preco_item_id = 0;

                if (Tabela_preco_itemService::salvar($tabela_preco_item, $this->campo, $this->tabela) <= 1) {
                    // Se não inseriu, adiciona uma mensagem de erro ao array
                    $erros[] = 'Erro ao salvar no banco de dados';
                }
            }

            if (!empty($erros)) {
                // Se houver erros, responde com as mensagens acumuladas

                echo json_encode(['success' => false, 'errors' => $erros]);
            } else {
                // Se não houver erros, responde com sucesso
                echo json_encode(['success' => true]);
            }
        }
    }

}
