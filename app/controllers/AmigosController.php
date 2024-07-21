<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\AmigosService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\ConvitesService;
use app\models\service\Participantes_despesasService;
use app\models\service\UsersService;

class AmigosController extends Controller
{
    private $tabela = "amigos";
    private $campo = "amigos_id";
    private $view = "vw_amigos";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function home() {  

        $dadosUsuario = Service::get("users", "users_id", $_SESSION['id']);
        if(!isset($dadosUsuario->auth_token)){
            $newAuthToken = bin2hex(random_bytes(32));
            $users = new \stdClass();
            $users->users_id =  $_SESSION['id'];
            $users->auth_token =  $newAuthToken;
 
            if (UsersService::salvar($users) == 1) 
            {
                $dados["newAuthToken"] = $newAuthToken;
            }
        }else{
            $dados["newAuthToken"] = $dadosUsuario->auth_token ; 
        }

        $dados["minhasDespesas"] = Participantes_despesasService::resumoValoresAmigos($_SESSION['id']);
        $todosAmigos = AmigosService::meusAmigos($_SESSION['id']);

        $despesas_ids = array_map(function($despesa) {
            return $despesa->users_id;
        }, $dados["minhasDespesas"]);
        
        // Filtrar o array todosAmigos
        $dados["todosAmigos"] = array_filter($todosAmigos, function($amigo) use ($despesas_ids) {
            return !in_array($amigo->users_id, $despesas_ids);
        });

        $dados["saldo"] = Participantes_despesasService::saldoUsuario($_SESSION['id']);
        $dados["btnAtivo"] = "amigos";
        $dados["view"] = "Amigos/Home";
        $this->load("templateBootstrap", $dados);          
    }

    public function create()
    {
        $dados["amigos"] = Flash::getForm();
        $dados["users"] = service::lista("users");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["view"] = "Amigos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $amigos = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $amigos->amigos_id = 0; 
                $amigos->usuario_id = $_SESSION['id'];
                if (isset($_POST["amigo"]))
                    $amigos->amigo = $_POST["amigo"];                  
            }


            Flash::setForm($amigos);
            if (AmigosService::salvar($amigos) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Amigos/home");
            } else {
                if ($amigos->amigos_id > 0) {
                    $this->redirect(URL_BASE . "Amigos/edit/" . $amigos->amigos_id);
                } else {
                    $this->redirect(URL_BASE . "Amigos/create");                    
                }
            }
        }
    }
}

