<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Participantes_despesasService;
use app\core\Flash;
use app\models\service\Service;

class Participantes_despesasController extends Controller
{
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                
                // Excluir a imagem, se existir               

                // Excluir
                Participantes_despesasService::excluir($id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $participantes_despesas = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["participantes_despesas_id"]) && is_numeric($_POST["participantes_despesas_id"]) && $_POST["participantes_despesas_id"] > 0) {                  
                    $participantes_despesas->participantes_despesas_id = $_POST["participantes_despesas_id"];                    
                } else {
                    $participantes_despesas->participantes_despesas_id = 0;                         
                }
                if (isset($_POST["despesas_id"]))
                   $participantes_despesas->despesas_id = $_POST["despesas_id"];
                if (isset($_POST["users_id"]))
                   $participantes_despesas->users_id = $_POST["users_id"];
                if (isset($_POST["devendo_para"]))
                   $participantes_despesas->devendo_para = $_POST["devendo_para"];
                if (isset($_POST["valor"]))
                   $participantes_despesas->valor = $_POST["valor"];
                if (isset($_POST["valor_pago"]))
                   $participantes_despesas->valor_pago = $_POST["valor_pago"];
                
               
            }


            Flash::setForm($participantes_despesas);
            if (Participantes_despesasService::salvar($participantes_despesas) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE   . "Participantes_despesas");
            } else {
                if (!$participantes_despesas->participantes_despesas_id) {
                    $this->redirect(URL_BASE   . "Participantes_despesas/create");
                } else {
                    $this->redirect(URL_BASE   . "Participantes_despesas/edit/" . $participantes_despesas->participantes_despesas_id);
                }
            }
        }
    }

}
