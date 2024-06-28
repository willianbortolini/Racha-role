<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\models\service\Participantes_despesasService;
use app\util\UtilService;

class HomeController extends Controller {

    private $usuario;
    public function __construct() {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function index() {  
        $dados["minhasDespesas"] = Participantes_despesasService::meusDebitosEmAberto($_SESSION['id']);
        $dados["view"] = "Home/Home";
        $this->load("templateBootstrap", $dados);          
    }

}
