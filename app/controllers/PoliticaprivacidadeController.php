<?php

namespace app\controllers;

use app\core\Controller;

class PoliticaprivacidadeController extends Controller {

    public function index() {

        $this->load("PoliticaPrivacidade/politicaprivacidade");
    }
    
 }
