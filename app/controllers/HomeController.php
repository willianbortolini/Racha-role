<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
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
        $this->redirect(URL_BASE. 'inventario');      
    }

    public function ClpComArduino() {  
        $dados["curso"] = Service::get('cursos','cursos_id',1);
        $dados["view"] = "Home/ClpComArduino";
        $this->load("templateBootstrap", $dados);        
    }

}
