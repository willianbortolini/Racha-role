<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\TicketService;
use app\core\Flash;
use app\models\service\Service;

class TicketController extends Controller
{
    private $tabela = "tickets";
    private $campo = "tickets_id";
    private $view = "vw_tickets";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $dados["tickets"] = Service::lista($this->view);
        $dados["view"] = "Ticket/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["tickets"] = Service::get($this->view, $this->campo, $id);
        $dados["usuarios"] = service::lista("usuarios");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["priority"] = service::getEnumValues($this->tabela, "priority");
        $dados["view"] = "Ticket/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["tickets"] = Flash::getForm();
        $dados["usuarios"] = service::lista("usuarios");
        $dados["status"] = service::getEnumValues($this->tabela, "status");
        $dados["priority"] = service::getEnumValues($this->tabela, "priority");
        $dados["view"] = "Ticket/Edit";
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
                if (isset($existe_imagem->imagem_perfil) && $existe_imagem->imagem_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->imagem_perfil);
                }

                // Excluir
                TicketService::excluir($id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $ticket = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["tickets_id"]) && is_numeric($_POST["tickets_id"]) && $_POST["tickets_id"] > 0) {                  
                    $ticket->tickets_id = $_POST["tickets_id"];                    
                } else {
                    $ticket->tickets_id = 0;                         
                }
                if (isset($_POST["user_id"]))
                   $ticket->user_id = $_POST["user_id"];
                if (isset($_POST["subject"]))
                   $ticket->subject = $_POST["subject"];
                if (isset($_POST["description"]))
                   $ticket->description = $_POST["description"];
                if (isset($_POST["status"]))
                   $ticket->status = $_POST["status"];
                if (isset($_POST["priority"]))
                   $ticket->priority = $_POST["priority"];
                
               
            }


            Flash::setForm($ticket);
            if (TicketService::salvar($ticket) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Ticket");
            } else {
                if (!$ticket->tickets_id) {
                    $this->redirect(URL_BASE   . "Ticket/create");
                } else {
                    $this->redirect(URL_BASE   . "Ticket/edit/" . $ticket->tickets_id);
                }
            }
        }
    }

}
