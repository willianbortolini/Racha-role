<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\CursosService;
use app\core\Flash;
use app\models\service\Service;

class CursosController extends Controller
{
    private $tabela = "Cursos";
    private $campo = "Cursos_id";
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
        $dados["Cursos"] = Service::lista($this->tabela);
        $dados["view"] = "Cursos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["Cursos"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Cursos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["Cursos"] = Flash::getForm();
        $dados["view"] = "Cursos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                
                // Excluir a imagem, se existir               
                $existe_imagem = service::get($this->tabela, $this->campo, $id);
                if (isset($existe_imagem->url_imagem) && $existe_imagem->url_imagem != '') {
                    UtilService::deletarImagens($existe_imagem->url_imagem);
                }

                // Excluir
                CursosService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $cursos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["Cursos_id"]) && is_numeric($_POST["Cursos_id"]) && $_POST["Cursos_id"] > 0) {                  
                    $cursos->Cursos_id = $_POST["Cursos_id"];                    
                } else {
                    $cursos->Cursos_id = 0;                         
                }
                                if (isset($_POST["nome"]))
                   $cursos->nome = $_POST["nome"];
                if (isset($_POST["area"]))
                   $cursos->area = $_POST["area"];
                if (isset($_POST["descricao"]))
                   $cursos->descricao = $_POST["descricao"];
                if (isset($_POST["desconto"]))
                   $cursos->desconto = $_POST["desconto"];
                if (isset($_POST["preco_original"]))
                   $cursos->preco_original = $_POST["preco_original"];
                if (isset($_POST["preco"]))
                   $cursos->preco = $_POST["preco"];
                if (isset($_POST["professor_id"]))
                   $cursos->professor_id = $_POST["professor_id"];
                
               
            }


            Flash::setForm($cursos);
            if (CursosService::salvar($cursos, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Cursos");
            } else {
                if (!$cursos->Cursos_id) {
                    $this->redirect(URL_BASE   . "Cursos/create");
                } else {
                    $this->redirect(URL_BASE   . "Cursos/edit/" . $cursos->Cursos_id);
                }
            }
        }
    }

}
