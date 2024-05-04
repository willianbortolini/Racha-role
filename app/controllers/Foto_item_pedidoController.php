<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Foto_item_pedidoService;
use app\core\Flash;
use app\models\service\Service;

class Foto_item_pedidoController extends Controller
{
    private $tabela = "foto_item_pedido";
    private $campo = "foto_item_pedido_id";
    private $usuario;

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["foto_item_pedido"] = Service::lista($this->tabela);
        $dados["view"] = "Foto_item_pedido/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["foto_item_pedido"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Foto_item_pedido/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create($id)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["pedido_item_id"] = $id;
        $dados["foto_item_pedido"] = Flash::getForm();
        $dados["view"] = "Foto_item_pedido/Edit";
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
                if (isset($existe_imagem->foto_item_pedido_caminho) && $existe_imagem->foto_item_pedido_caminho != '') {
                    UtilService::deletarImagens($existe_imagem->foto_item_pedido_caminho);
                }

                // Excluir
                Foto_item_pedidoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $foto_item_pedido = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["foto_item_pedido_id"]) && is_numeric($_POST["foto_item_pedido_id"]) && $_POST["foto_item_pedido_id"] > 0) {
                    $foto_item_pedido->foto_item_pedido_id = $_POST["foto_item_pedido_id"];
                } else {
                    $foto_item_pedido->foto_item_pedido_id = 0;
                }
                if (isset($_POST["pedido_item_id"]))
                    $foto_item_pedido->pedido_item_id = $_POST["pedido_item_id"];
            }

            Flash::setForm($foto_item_pedido);

            if (Foto_item_pedidoService::salvar($foto_item_pedido, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Pedido_item/edit/" . $foto_item_pedido->pedido_item_id);
            } else {
                if (!$foto_item_pedido->foto_item_pedido_id) {
                    $this->redirect(URL_BASE . "Foto_item_pedido/create/" . $foto_item_pedido->pedido_item_id);
                } else {
                    $this->redirect(URL_BASE . "Foto_item_pedido/edit/" . $foto_item_pedido->foto_item_pedido_id);
                }
            }
        }
    }

}
