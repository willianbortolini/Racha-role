<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\DespesasService;
use app\models\service\Participantes_despesasService;
use app\models\service\GruposService;
use app\models\service\AmigosService;
use app\models\service\UsersService;
use app\core\Flash;
use app\models\service\Service;

class DespesasController extends Controller
{
    private $tabela = "despesas";
    private $campo = "despesas_id";
    private $view = "vw_despesas";

    public function __construct()
    {
        UsersService::usuarioLogado();
    }

    public function detalhe($user_uid)
    {
        $dados["amigo"] = Service::get("users", "users_uid", $user_uid);
        $user_id = $dados["amigo"]->users_id;
        $dados["detalhe"] = Participantes_despesasService::negociacoesEntreDoisUsuarios($_SESSION['id'], $user_id);
        $dados["saldo"] = Participantes_despesasService::totalDividasEntreUsuarios($_SESSION['id'], $user_id);
        $dados["view"] = "Despesas/DetalheUsuario";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["despesas"] = Service::get($this->view, $this->campo, $id);
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);
        $dados["grupos"] = GruposService::gruposDoUsuario($_SESSION['id']);
        $dados["view"] = "Despesas/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["despesas"] = Flash::getForm();
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);
        $dados["grupos"] = GruposService::gruposDoUsuario($_SESSION['id']);

        $dados["view"] = "Despesas/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {

    }

    public function desativa($despesas_id, $user_uid)
    {
        $despesas = new \stdClass();
        $despesas->despesas_id = $despesas_id;
        $despesas->ativo = 0;
        Service::salvar($despesas, 'despesas_id', [], 'despesas');
        $this->redirect(URL_BASE . "despesas/detalhe/" . $user_uid);
    }

    public function ativar($despesas_id, $user_uid)
    {
        $despesas = new \stdClass();
        $despesas->despesas_id = $despesas_id;
        $despesas->ativo = 1;
        Service::salvar($despesas, 'despesas_id', [], 'despesas');
        $this->redirect(URL_BASE . "despesas/detalhe/" . $user_uid);
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $despesas = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["despesas_id"]) && is_numeric($_POST["despesas_id"]) && $_POST["despesas_id"] > 0) {
                    $despesas->despesas_id = $_POST["despesas_id"];
                } else {
                    $despesas->despesas_id = 0;
                }
                if (isset($_POST["descricao"]))
                    $despesas->descricao = $_POST["descricao"];
                if (isset($_POST["valor"]))
                    $despesas->valor = $_POST["valor"];
                if (isset($_POST["data"]))
                    $despesas->data = $_POST["data"];
                if (isset($_POST["users_id"]))
                    $despesas->users_id = $_POST["users_id"];
                if (isset($_POST["grupos_id"]))
                    $despesas->grupos_id = $_POST["grupos_id"];
            }
            $participantes = $_POST['participantes']; // Array de IDs de participantes
            $valorPorParticipante = $_POST['valorporparticipante']; // Array de IDs de participantes
            Flash::setForm($despesas);
            $despesa = DespesasService::salvar($despesas, $participantes, $valorPorParticipante);
            if ($despesa > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE);
            } else {
                if (!$despesas->despesas_id) {
                    $this->redirect(URL_BASE . "Despesas/create");
                } else {
                    $this->redirect(URL_BASE . "Despesas/edit/" . $despesas->despesas_id);
                }
            }
        }
    }

   

}
