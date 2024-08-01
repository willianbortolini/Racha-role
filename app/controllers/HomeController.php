<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\Participantes_despesasService;
use app\models\service\Usuarios_gruposService;
use app\util\UtilService;

class HomeController extends Controller
{

    private $usuario;
    public function __construct()
    {
        if (!isset($_SESSION['id'])) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function index()
    {
        if (isset($_SESSION['group_id'])) {
            $usuarios_grupos = new \stdClass();
            $usuarios_grupos->usuarios_grupos_id = 0;
            $usuarios_grupos->grupos_id = $_SESSION['group_id'];
            $participantes = [$_SESSION['id']];
            Usuarios_gruposService::salvar($usuarios_grupos, $participantes);

            unset($_SESSION['group_id']);
            Flash::limpaMsg();
            $this->redirect(URL_BASE . "grupos/Home");
        }else{
            $this->redirect(URL_BASE . "amigos/Home");
        }
    }

}
