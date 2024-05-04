<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Ordem_producao_itemService;
use app\core\Flash;
use app\models\service\Service;

class Ordem_producao_itemController extends Controller
{
   private $tabela = "ordem_producao_item";
   private $campo = "ordem_producao_item_id";
   private $usuario;

   //verifica se tem usuario logado(somente para telas que exigem)
   public function __construct()
   {
      UtilService::validaUsuario();
   }

   public function index()
   {
      $dados["ordem_producao_item"] = Service::lista($this->tabela);
      $dados["view"] = "Ordem_producao_item/Show";
      $this->load("templateBootstrap", $dados);
   }

   public function edit($id)
   {
      $dados["ordem_producao_item"] = Service::get($this->tabela, $this->campo, $id);
      $dados["view"] = "Ordem_producao_item/Edit";
      $this->load("templateBootstrap", $dados);
   }

   public function create()
   {
      $dados["ordem_producao_item"] = Flash::getForm();
      $dados["view"] = "Ordem_producao_item/Edit";
      $this->load("templateBootstrap", $dados);
   }  

   public function delete()
   {
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
         $csrfToken = $_POST['csrf_token'];
         if ($csrfToken === $_SESSION['csrf_token']) {
            $id = $_POST['id'];
            Ordem_producao_itemService::excluir($this->tabela, $this->campo, $id);
         }
      }
   }

   public function save()
   {
      $csrfToken = $_POST['csrf_token'];
      if ($csrfToken === $_SESSION['csrf_token']) {
         $ordem_producao_item = new \stdClass();
         if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if (isset($_POST["ordem_producao_item_id"]) && is_numeric($_POST["ordem_producao_item_id"]) && $_POST["ordem_producao_item_id"] > 0) {
               $ordem_producao_item->ordem_producao_item_id = $_POST["ordem_producao_item_id"];
            } else {
               $ordem_producao_item->ordem_producao_item_id = 0;
            }
            if (isset($_POST["ordem_producao_id"]))
               $ordem_producao_item->ordem_producao_id = $_POST["ordem_producao_id"];
            if (isset($_POST["ambiente"]))
               $ordem_producao_item->ambiente = $_POST["ambiente"];
            if (isset($_POST["modelo"]))
               $ordem_producao_item->modelo = $_POST["modelo"];
            if (isset($_POST["largura"]))
               $ordem_producao_item->largura = $_POST["largura"];
            if (isset($_POST["altura"]))
               $ordem_producao_item->altura = $_POST["altura"];
         }

         Flash::setForm($ordem_producao_item);
         if (Ordem_producao_itemService::salvar($ordem_producao_item, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
         {
            $this->redirect(URL_BASE . "Ordem_producao_item");
         } else {
            if (!$ordem_producao_item->ordem_producao_item_id) {
               $this->redirect(URL_BASE . "Ordem_producao_item/create");
            } else {
               $this->redirect(URL_BASE . "Ordem_producao_item/edit/" . $ordem_producao_item->ordem_producao_item_id);
            }
         }
      }
   }

}
