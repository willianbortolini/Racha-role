<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\core\Flash;
use app\models\service\Usuarios_gruposService;
use app\models\service\AmigosService;
use app\models\service\Service;

class Usuarios_gruposController extends Controller
{
    private $tabela = "usuarios_grupos";
    private $campo = "usuarios_grupos_id";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function usuariosDoGrupo($id)
    {
        echo json_encode(Service::get($this->tabela, "grupos_id", $id, true));
    }
    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $amigos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["usuarios_grupos_id"]) && is_numeric($_POST["usuarios_grupos_id"]) && $_POST["usuarios_grupos_id"] > 0) {
                    $amigos->usuarios_grupos_id = $_POST["usuarios_grupos_id"];
                } else {
                    $amigos->usuarios_grupos_id = 0;
                }
                if (isset($_POST["grupos_id"]))
                    $amigos->grupos_id = $_POST["grupos_id"];

                $participantes = $_POST["participantes"];
            }
            Flash::setForm($amigos);
            if (Usuarios_gruposService::salvar($amigos, $participantes) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Grupos/edit/" . $amigos->grupos_id);
            } else {
                if (!$amigos->grupos_id) {
                    $this->redirect(URL_BASE . "Grupos/edit/" . $amigos->grupos_id);
                } else {
                    $this->redirect(URL_BASE . "Grupos/edit/" . $amigos->grupos_id);
                }
            }
        }
    }


}
