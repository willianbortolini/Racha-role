<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\GruposService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\Usuarios_gruposService;

class GruposController extends Controller
{
    private $tabela = "grupos";
    private $campo = "grupos_id";


    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $teste = new GruposService;
        $dados["grupos"] = GruposService::lista();
        i($dados["grupos"]);
        $dados["view"] = "Grupos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["grupos"] = Service::get($this->tabela, $this->campo, $id);

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
                if (isset($_POST["nome"])) {
                    $grupos->nome = $_POST["nome"];
                }
            }

            Flash::setForm($grupos);
            Service::begin_tran();

            try {
                $grupos_id = GruposService::salvar($grupos);
                if ($grupos_id > 1) {
                    // Insere novo grupo e coloca o usuário atual como membro do grupo
                    $usuarios_grupos = new GruposService;
                    $usuarios_grupos->usuarios_grupos_id = 0;
                    $usuarios_grupos->users_id = $_SESSION['id'];
                    $usuarios_grupos->grupos_id = $grupos_id;

                    if (Usuarios_gruposService::salvar($usuarios_grupos) > 1) {
                        Service::commit();
                        $this->redirect(URL_BASE . "Grupos");
                    } else {
                        Service::rollback();
                        $this->redirect(URL_BASE . "Grupos/create");
                        exit;
                    }
                } else {
                    if (!$grupos->grupos_id) {
                        Service::rollback();
                        $this->redirect(URL_BASE . "Grupos/create");
                    } else {
                        Service::commit();
                        $this->redirect(URL_BASE . "Grupos/edit/" . $grupos->grupos_id);
                    }
                }
            } catch (\Exception $e) {
                Service::rollback();
                $this->redirect(URL_BASE . "Grupos/create");
                exit;
            }
        }
    }

}
