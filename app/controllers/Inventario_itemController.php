<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Inventario_itemService;
use app\core\Flash;
use app\models\service\Service;

class Inventario_itemController extends Controller
{
    private $tabela = "inventario_item";
    private $campo = "inventario_item_id";
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

    public function index($inventario_id)
    {
        $dados["inventario_item"] = Service::get($this->tabela, 'inventario_id', $inventario_id, true);
        $dados["inventario"] = $inventario_id;
        $dados["view"] = "Inventario_item/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["inventario_item"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Inventario_item/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function coletor($inventario_id)
    {
        $dados["inventario"] = $inventario_id;
        $dados["identidades"] = Inventario_itemService::identiradesContadas($inventario_id);
        $dados["view"] = "Inventario_item/Coletor";
        $this->load("template", $dados);
    }

    public function create($inventario_id)
    {
        $dados["inventario_item"] = Flash::getForm();
        $dados["inventario"] = $inventario_id;
        $dados["view"] = "Inventario_item/Edit";
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
                Inventario_itemService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $inventario_item = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["inventario_item_id"]) && is_numeric($_POST["inventario_item_id"]) && $_POST["inventario_item_id"] > 0) {
                    $inventario_item->inventario_item_id = $_POST["inventario_item_id"];
                } else {
                    $inventario_item->inventario_item_id = 0;
                }
                if (isset($_POST["inventario_id"]))
                    $inventario_item->inventario_id = $_POST["inventario_id"];
                if (isset($_POST["nome"]))
                    $inventario_item->nome = $_POST["nome"];
                if (isset($_POST["quantidade"]))
                    $inventario_item->quantidade = $_POST["quantidade"];
                if (isset($_POST["preco"]))
                    $inventario_item->preco = $_POST["preco"];
                if (isset($_POST["ean13"]))
                    $inventario_item->ean13 = $_POST["ean13"];
                if (isset($_POST["quantidade"]))
                    $inventario_item->quantidade = $_POST["quantidade"];

                $inventario_item->usuarios_id = $_SESSION['id'];

            }


            Flash::setForm($inventario_item);
            if (Inventario_itemService::salvar($inventario_item, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Inventario_item/index/" . $inventario_item->inventario_id);
            } else {
                if (!$inventario_item->inventario_item_id) {
                    $this->redirect(URL_BASE . "Inventario_item/create/" . $inventario_item->inventario_id);
                } else {
                    $this->redirect(URL_BASE . "Inventario_item/edit/" . $inventario_item->inventario_item_id);
                }
            }
        }
    }

    public function saveEan()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $inventario_item = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["inventario_item_id"]) && is_numeric($_POST["inventario_item_id"]) && $_POST["inventario_item_id"] > 0) {
                    $inventario_item->inventario_item_id = $_POST["inventario_item_id"];
                } else {
                    $inventario_item->inventario_item_id = 0;
                }
                if (isset($_POST["inventario_id"]))
                    $inventario_item->inventario_id = $_POST["inventario_id"];
                if (isset($_POST["nome"]))
                    $inventario_item->nome = $_POST["nome"];
                if (isset($_POST["quantidade"]))
                    $inventario_item->quantidade = $_POST["quantidade"];
                if (isset($_POST["preco"]))
                    $inventario_item->preco = $_POST["preco"];
                if (isset($_POST["ean13"]))
                    $inventario_item->ean13 = $_POST["ean13"];

            }
            if (Inventario_itemService::salvar($inventario_item, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Item inserido com sucesso.',
                    'inventario_id' => $inventario_item->inventario_id
                ]);
                Flash::limpaErro();
                Flash::limpaMsg();
            } else {
                http_response_code(400); // Código de status HTTP para "Bad Request"
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Falha ao editar o item do inventário.',
                    'inventario_item_id' => $inventario_item->inventario_item_id
                ]);
                Flash::limpaErro();
                Flash::limpaMsg();
            }
        }
    }

}
