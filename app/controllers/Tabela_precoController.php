<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Tabela_precoService;
use app\models\service\Tabela_preco_itemService;
use app\core\Flash;
use app\models\service\Service;

class Tabela_precoController extends Controller
{
    private $tabela = "tabela_preco";
    private $campo = "tabela_preco_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["tabela_preco"] = Service::lista($this->tabela);
        $dados["view"] = "Tabela_preco/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["tabela_preco"] = Service::get($this->tabela, $this->campo, $id);
        $dados["tabela_preco_itens"] = Service::get('tabela_preco_item', $this->campo, $id, true, 'asc');
        $dados["produtos"] = Service::lista('produtos');
        $dados["view"] = "Tabela_preco/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["tabela_preco"] = Flash::getForm();
        $dados["view"] = "Tabela_preco/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function help()
    {
        $dados["view"] = "Tabela_preco/Help";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Tabela_preco_itemService::excluir('tabela_preco_item', 'tabela_preco_id', $id);
                Tabela_precoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $tabela_preco = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["tabela_preco_id"]) && is_numeric($_POST["tabela_preco_id"]) && $_POST["tabela_preco_id"] > 0) {
                    $tabela_preco->tabela_preco_id = $_POST["tabela_preco_id"];
                } else {
                    $tabela_preco->tabela_preco_id = 0;
                }
                if (isset($_POST["tabela_preco_nome"]))

                    $tabela_preco->tabela_preco_nome = $_POST["tabela_preco_nome"];

            }


            Flash::setForm($tabela_preco);
            if (Tabela_precoService::salvar($tabela_preco, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Tabela_preco");
            } else {
                if (!$tabela_preco->tabela_preco_id) {
                    $this->redirect(URL_BASE . "Tabela_preco/create");
                } else {
                    $this->redirect(URL_BASE . "Tabela_preco/edit/" . $tabela_preco->tabela_preco_id);
                }
            }
        }
    }

}
