<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\ReservaService;
use app\core\Flash;
use app\models\service\Service;

class ReservaController extends Controller
{
    private $tabela = "reserva";
    private $campo = "reserva_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["reserva"] = Service::lista("vw_reserva");
        $dados["view"] = "Reserva/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function pesquisar()
    {
        $pesquisa = new \stdClass();
        $pesquisa->reservado_sim = (isset($_POST["reservado_sim"])) ? 1 : 0;
        $pesquisa->reservado_nao = (isset($_POST["reservado_nao"])) ? 1 : 0;
        $pesquisa->pedidos = (isset($_POST["pedidos"])) ? $_POST["pedidos"] : [];        
        $dados["pedidos"] = Service::lista("ordem_producao", "asc");
        $dados["reserva"] = ReservaService::pesquisa(clone $pesquisa);
        $dados["pesquisa"] = $pesquisa;
        $dados["view"] = "Reserva/Agrupado";
        $this->load("templateBootstrap", $dados);
    }

    public function agrupado()
    {
        $dados["reserva"] = Service::lista("vw_reserva");
        $dados["view"] = "Reserva/Agrupado";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["reserva"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Reserva/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["reserva"] = Flash::getForm();
        $dados["view"] = "Reserva/Edit";
        $this->load("templateBootstrap", $dados);
    }

    /*public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                ReservaService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }*/

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $reserva = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["reserva_id"]) && is_numeric($_POST["reserva_id"]) && $_POST["reserva_id"] > 0) {
                    $reserva->reserva_id = $_POST["reserva_id"];
                } else {
                    $reserva->reserva_id = 0;
                }
                if (isset($_POST["produtos_id"]))
                    $reserva->produtos_id = $_POST["produtos_id"];
                if (isset($_POST["quantidade"]))
                    $reserva->quantidade = $_POST["quantidade"];
                if (isset($_POST["tipo"]))
                    $reserva->tipo = $_POST["tipo"];
                if (isset($_POST["reservado"]))
                    $reserva->reservado = $_POST["reservado"];
                if (isset($_POST["documento"]))
                    $reserva->documento = $_POST["documento"];
                if (isset($_POST["descricao"]))
                    $reserva->descricao = $_POST["descricao"];
            }
            Flash::setForm($reserva);
            if (ReservaService::salvar($reserva) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Reserva");
            } else {
                if (!$reserva->reserva_id) {
                    $this->redirect(URL_BASE . "Reserva/create");
                } else {
                    $this->redirect(URL_BASE . "Reserva/edit/" . $reserva->reserva_id);
                }
            }
        }
    }

}
