<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;

//use app\models\service\LoginService;

class LoadingController extends Controller {
  
    public function index() {
        $this->redirect(URL_BASE . "laddertoc");
        
        /*$dados["cursos"]            = EscolaService::meusCursos($_SESSION[SESSION_LOGIN]->id_usuario);
        $dados["aulasAssistidas"]   = EscolaService::aulas_assistidas();
        $dados["view"]              = "Escola/Index";
        $this->load("Escola/templateescola", $dados);*/
    }
    
   /* public function loading($curso) { 
        if($_SESSION[SESSION_LOGIN]->id_usuario){
            $dados["view"] = "Escola/loading";
            $this->load("Escola/templateescola", $dados);
        }else{
            $dados["view"] = "Escola/loading";
            $this->load("Escola/templateescolaEx", $dados);
        }        
    } */  

}
