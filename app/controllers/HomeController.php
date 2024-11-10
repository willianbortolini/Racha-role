<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Flash;
use app\models\service\Usuarios_gruposService;

class HomeController extends Controller
{

    private $usuario;
    public function __construct()
    {
        if (!isset($_SESSION['id'])) {
            $dados["view"] = "Home/Index";
            $this->load("templateBootstrap", $dados);
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
