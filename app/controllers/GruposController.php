<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\GruposService;
use app\models\service\Usuarios_gruposService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\AmigosService;
use app\models\service\Participantes_despesasService;

class GruposController extends Controller
{
    private $tabela = "grupos";
    private $campo = "grupos_id";


    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function home()
    {
        $dados["minhasDespesas"] = Participantes_despesasService::meusValoresPorGrupo($_SESSION['id']);
        $dados["saldo"] = Participantes_despesasService::saldoUsuario($_SESSION['id']);
        $dados["gruposQuitados"] = GruposService::gruposQuitados($_SESSION['id']);
        $dados["btnAtivo"] = "grupos";
        i($dados);
        $dados["view"] = "Grupos/home";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);        
        $dados["grupos"] = Service::get($this->tabela, $this->campo, $id);
        $dados["membroGrupo"] = Usuarios_gruposService::membrosDoGrupo($id);
        $dados["users"] = AmigosService::meusAmigos($_SESSION['id']);
        $dados["view"] = "Grupos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["grupos"] = Flash::getForm();

        $dados["view"] = "Grupos/Edit";
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
                if (isset($existe_imagem->foto) && $existe_imagem->foto != '') {
                    UtilService::deletarImagens($existe_imagem->foto);
                }

                // Excluir
                GruposService::excluir($id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {

            $grupos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["grupos_id"]) && is_numeric($_POST["grupos_id"]) && $_POST["grupos_id"] > 0) {
                    $grupos->grupos_id = $_POST["grupos_id"];
                } else {
                    $grupos->grupos_id = 0;
                }
                if (isset($_POST["nome"]))
                    $grupos->nome = $_POST["nome"];

            }

            Flash::setForm($grupos);
            Service::begin_tran();
            try {
                $grupos_id = GruposService::salvar($grupos); //se é maior que um inseriu novo
                if ($grupos_id > 1) //se é maior que um inseriu novo 
                {
                    Service::commit();
                    $this->redirect(URL_BASE . "Grupos/edit/" . $grupos_id);
                } else {
                    if (!$grupos->grupos_id) {
                        $this->redirect(URL_BASE . "Grupos/create");
                    } else {
                        Service::commit();
                        $this->redirect(URL_BASE . "Grupos/edit/" . $grupos->grupos_id);
                        
                    }
                }
            } catch (\Exception $e) {
                Flash::setMsg($e->getMessage());
                $this->redirect(URL_BASE . "Pagamentos");
                Service::rollback();
            }
        }
    }

}
