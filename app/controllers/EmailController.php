<?php
namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\CategoriaService;

class EmailController extends Controller{
   private $tabela = "categoria";
   private $campo  = "id_categoria";
   
   
    public function index(){
        i(Service::email());
    }
    
   
}

