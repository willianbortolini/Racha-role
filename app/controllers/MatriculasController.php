<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\MatriculasService;
use app\core\Flash;
use app\models\service\Service;

class MatriculasController extends Controller
{
    private $tabela = "matriculas";
    private $campo = "matriculas_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    /*public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE  . "login");
            exit;
        }
    }*/

    public function index()
    {
        $dados["matriculas"] = Service::lista($this->tabela);
        $dados["view"] = "Matriculas/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["matriculas"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Matriculas/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["matriculas"] = Flash::getForm();
        $dados["view"] = "Matriculas/Edit";
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
                MatriculasService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $matriculas = new \stdClass();
                if (isset($_POST["matriculas_id"]) && is_numeric($_POST["matriculas_id"]) && $_POST["matriculas_id"] > 0) {                  
                    $matriculas->matriculas_id = $_POST["matriculas_id"];                    
                } else {
                    $matriculas->matriculas_id = 0;                         
                }
                                if (isset($_POST["usuarios_id"]))
                   $matriculas->usuarios_id = $_POST["usuarios_id"];
                if (isset($_POST["cursos_id"]))
                   $matriculas->cursos_id = $_POST["cursos_id"];
                if (isset($_POST["recebimentos_id"]))
                   $matriculas->recebimentos_id = $_POST["recebimentos_id"];
                
               
            }


            Flash::setForm($matriculas);
            if (MatriculasService::salvar($matriculas, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Matriculas");
            } else {
                if (!$matriculas->matriculas_id) {
                    $this->redirect(URL_BASE   . "Matriculas/create");
                } else {
                    $this->redirect(URL_BASE   . "Matriculas/edit/" . $matriculas->matriculas_id);
                }
            }
        }
    }

}
