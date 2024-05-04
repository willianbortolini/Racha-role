<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Usuario_tipoService;
use app\core\Flash;
use app\models\service\Service;

class Usuario_tipoController extends Controller
{
    private $tabela = "usuario_tipo";
    private $campo = "usuario_tipo_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["usuario_tipo"] = Service::lista($this->tabela);
        $dados["view"] = "Usuario_tipo/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["usuario_tipo"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Usuario_tipo/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["usuario_tipo"] = Flash::getForm();
        $dados["view"] = "Usuario_tipo/Edit";
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
                Usuario_tipoService::excluir($id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $usuario_tipo = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["usuario_tipo_id"]) && is_numeric($_POST["usuario_tipo_id"]) && $_POST["usuario_tipo_id"] > 0) {
                    $usuario_tipo->usuario_tipo_id = $_POST["usuario_tipo_id"];
                } else {
                    $usuario_tipo->usuario_tipo_id = 0;
                }
                if (isset($_POST["usuarios_id"]))
                    $usuario_tipo->usuarios_id = $_POST["usuarios_id"];
                if (isset($_POST["usuario_tipo"]))
                    $usuario_tipo->usuario_tipo = $_POST["usuario_tipo"];

                $usuario_tipo->empresa = $_SESSION['id'];
            }


            Flash::setForm($usuario_tipo);
            if (Usuario_tipoService::salvar($usuario_tipo) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Usuario_tipo");
            } else {
                if (!$usuario_tipo->usuario_tipo_id) {
                    $this->redirect(URL_BASE . "Usuario_tipo/create");
                } else {
                    $this->redirect(URL_BASE . "Usuario_tipo/edit/" . $usuario_tipo->usuario_tipo_id);
                }
            }
        }
    }

}
