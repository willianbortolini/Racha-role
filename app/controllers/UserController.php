<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\UserService;
use app\core\Flash;
use app\models\service\Service;
use Exception;

class UserController extends Controller
{
   private $tabela = "usuarios";
   private $campo = "usuarios_id";
   private $usuario;

   //verifica se tem usuario logado(somente para telas que exigem)
   public function __construct()
   {
      UtilService::validaUsuario();
   }

   public function index()
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      $dados["usuarios"] = Service::lista($this->tabela);
      $dados["view"] = "Usuario/Show";
      $this->load("templateBootstrap", $dados);
   }

   public function habilitaRepresentante($id)
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      $usuario = new \stdClass();
      $usuario->usuarios_id = $id;
      $usuario->habilitado = 1;
      UserService::salvar($usuario, $this->campo, $this->tabela);
      $this->redirect(URL_BASE . "user/representantes");
   }

   public function desabilitaRepresentante($id)
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      $usuario = new \stdClass();
      $usuario->usuarios_id = $id;
      $usuario->habilitado = 0;
      UserService::salvar($usuario, $this->campo, $this->tabela);
      $this->redirect(URL_BASE . "user/representantes");
   }

   public function representantes()
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      $dados["usuarios"] = Service::get('usuarios', 'he_representante', 1, true);
      $dados["view"] = "Usuario/Show";
      $this->load("templateBootstrap", $dados);
   }
   public function clientes()
   {
      $dados["view"] = "Usuario/ShowClientes";
      $this->load("templateBootstrap", $dados);
   }

   public function colaboradores()
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      $dados["usuarios"] = Service::get('usuarios', 'he_colaborador', 1, true);
      $dados["view"] = "Usuario/Show";
      $this->load("templateBootstrap", $dados);
   }


   

   public function edit($usuarios_id)
   {
      if (($_SESSION['id'] == $usuarios_id) or (isset($_SESSION['he_administrador']))) {
         $dados["usuarios"] = Service::get($this->tabela, $this->campo, $usuarios_id);
         $dados["heMeuPerfil"] = $_SESSION['id'] == $usuarios_id;
         $dados["view"] = "Usuario/Edit";
         $this->load("templateBootstrap", $dados);
      } else {
         $this->redirect(URL_BASE);
      }
   }

   public function editarOrcamento($usuarios_id)
   {
      if (($_SESSION['id'] == $usuarios_id) or (isset($_SESSION['he_administrador']))) {
         $dados["usuarios"] = Service::get($this->tabela, $this->campo, $usuarios_id);
         $dados["view"] = "Usuario/EditarOrcamento";
         $this->load("templateBootstrap", $dados);
      } else {
         $this->redirect(URL_BASE);
      }
   }
   public function editImagemOrcamento($pagina, $usuarios_id)
   {
      if (($usuarios_id == $_SESSION['id']) or (isset($_SESSION['he_administrador']))) {
         $usuario = Service::get($this->tabela, $this->campo, $usuarios_id);
         $dados["conteudo"] = $usuario->{"orcamento_pagina_" . $pagina};
         $dados["pagina"] = $pagina;
         $dados["usuarios_id"] = $usuarios_id;
         $dados["view"] = "Usuario/EditarImagensOrcamento";
         $this->load("templateBootstrap", $dados);
      }
   }

   public function create()
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      $form = new \stdClass();
      if (Flash::getForm() == '') {
         $form->he_representante = 1;
      } else {
         $form = Flash::getForm();
      }
      $dados["usuarios"] = $form;
      $dados["view"] = "Usuario/Edit";
      $this->load("templateBootstrap", $dados);
   }

   public function createCliente()
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      $form = new \stdClass();
      if (Flash::getForm() == '') {
         $form->he_cliente = 1;
      } else {
         $form = Flash::getForm();
      }
      $dados["usuarios"] = $form;
      $dados["view"] = "Usuario/Edit";
      $this->load("templateBootstrap", $dados);
   }

   public function delete()
   {
      UtilService::validaNivel(ADIMINISTRADOR);
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
         $csrfToken = $_POST['csrf_token'];
         if ($csrfToken === $_SESSION['csrf_token']) {
            $id = $_POST['id'];

            UserService::excluir($this->tabela, $this->campo, $id);
         }
      }

   }

   public function listaUsuarios()
   {
      $dados_requisicao = $_REQUEST;

      // Lista de colunas da tabela
      $colunas = [
         0 => 'usuario',
         1 => 'celular',
         2 => 'fone',
         3 => 'estado',
         4 => 'cidade',
         5 => 'bairro',
         6 => 'email'
      ];


      if (!empty($dados_requisicao['search']['value'])) {
         $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
      } else {
         $valor_pesquisa = "";
      }

      $row_qnt_usuarios = UserService::quantidadeClientes($valor_pesquisa);

      $parametros = [
         'inicio' => intval($dados_requisicao['start']),
         'quantidade' => intval($dados_requisicao['length']),
         'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
         'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
         'valor_pesquisa' => $valor_pesquisa
      ];
      $usuarios = UserService::listaUsuarios($parametros);
      $dados = [];
      foreach ($usuarios as $usuario) {
         $registro = [];
         $registro[] = $usuario->usuario;
         $registro[] = $usuario->celular;
         $registro[] = $usuario->fone;
         $registro[] = $usuario->estado;
         $registro[] = $usuario->cidade;
         $registro[] = 'Bairro:' . $usuario->bairro . ', Rua:' . $usuario->rua . ', nº:' . $usuario->numero . ', complemento:' . $usuario->complemento;
         $registro[] = $usuario->email;
         $registro[] = "<a href='" . URL_BASE . "User/edit/" . $usuario->usuarios_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
        <button onclick='deletarItem(" . $usuario->usuarios_id . ")' type='button'
            class='btn btn-danger btn-sm mt-2' data-bs-toggle='modal'
            data-bs-target='#deleteModal'>
            Deletar
        </button>";
         $dados[] = $registro;
      }

      $resultado = [
         "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
         "recordsTotal" => $row_qnt_usuarios->total, // Quantidade de registros que há no banco de dados
         "recordsFiltered" => $row_qnt_usuarios->total,//intval($row_qnt_usuarios['qnt_usuarios']), // Total de registros quando houver pesquisa
         "data" => $dados // Array de dados com os registros retornados da tabela usuarios
      ];

      echo json_encode($resultado);
   }

   public function salvaOrcamento()
   {
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
         $json_data = file_get_contents("php://input");
         $data = json_decode($json_data, true);

         if ($data['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Token CSRF inválido']);
            exit;
         }

         $usuario = new \stdClass();
         $usuario->usuarios_id = $data["usuarios_id"];
         $usuario->{"orcamento_pagina_" . $data["pagina"]} = $data["html"];

         if (UserService::salvarImagemOrçamento($usuario, $this->campo, $this->tabela) > 1) {
            echo json_encode(['success' => true]);
         } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados']);
         }
      } else {
         http_response_code(405);
         echo json_encode(['success' => false, 'error' => 'Método não permitido']);
      }
      exit;
   }

   public function save()
   {
      $csrfToken = $_POST['csrf_token'];
      $usuario = new \stdClass();
      if ($csrfToken === $_SESSION['csrf_token']) {
         if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["usuarios_id"]) && is_numeric($_POST["usuarios_id"]) && $_POST["usuarios_id"] > 0) {
               $usuario->usuarios_id = $_POST["usuarios_id"];
            } else {
               $usuario->usuarios_id = 0;
               $usuario->nivel_de_acesso = REPRESENTANTE;
            }
            if (isset($_POST["email"]))
               $usuario->email = $_POST["email"];
            if (isset($_POST["senha"]))
               $usuario->senha = $_POST["senha"];
            if (isset($_POST["usuario"]))
               $usuario->usuario = $_POST["usuario"];
            if (isset($_POST["nome_completo"]))
               $usuario->nome_completo = $_POST["nome_completo"];
            if (isset($_POST["nome_fantasia"]))
               $usuario->nome_fantasia = $_POST["nome_fantasia"];
            if (isset($_POST["cpf"]))
               $usuario->cpf = $_POST["cpf"];
            if (isset($_POST["cnpj"]))
               $usuario->cnpj = $_POST["cnpj"];
            if (isset($_POST["fone"]))
               $usuario->fone = $_POST["fone"];
            if (isset($_POST["celular"]))
               $usuario->celular = $_POST["celular"];
            if (isset($_POST["cep"]))
               $usuario->cep = $_POST["cep"];
            if (isset($_POST["numero"]))
               $usuario->numero = $_POST["numero"];
            if (isset($_POST["rua"]))
               $usuario->rua = $_POST["rua"];
            if (isset($_POST["estado"]))
               $usuario->estado = $_POST["estado"];
            if (isset($_POST["cidade"]))
               $usuario->cidade = $_POST["cidade"];
            if (isset($_POST["complemento"]))
               $usuario->complemento = $_POST["complemento"];
            if (isset($_POST["bairro"]))
               $usuario->bairro = $_POST["bairro"];
            if (isset($_POST["ie"]))
               $usuario->ie = $_POST["ie"];
            if (isset($_POST["rg"]))
               $usuario->rg = $_POST["rg"];
            if (isset($_POST["usuarios_markup"]))
               $usuario->usuarios_markup = $_POST["usuarios_markup"];

            if (isset($_POST["he_cliente"]))
               $usuario->he_cliente = ($_POST["he_cliente"] == 'on') ? 1 : 0;
            if (isset($_POST["he_fornecedor"]))
               $usuario->he_fornecedor = ($_POST["he_fornecedor"] == 'on') ? 1 : 0;
            if (isset($_POST["he_colaborador"]))
               $usuario->he_colaborador = ($_POST["he_colaborador"] == 'on') ? 1 : 0;
            if (isset($_POST["he_representante"]))
               $usuario->he_representante = ($_POST["he_representante"] == 'on') ? 1 : 0;
            if (isset($_POST["he_gerente"]))
               $usuario->he_gerente = ($_POST["he_gerente"] == 'on') ? 1 : 0;
         }

         Flash::setForm($usuario);
         $usuarios_id = UserService::salvar($usuario, $this->campo, $this->tabela);
         if ($usuario->usuarios_id > 0) {
            //atualizou
            $this->redirect(URL_BASE . "User/edit/" . $usuario->usuarios_id);
         } else if ($usuarios_id > 0) {
            //criu novo
            $this->redirect(URL_BASE . "User/edit/" . $usuarios_id);
         } else {
            $this->redirect(URL_BASE . "User/create");
         }
      } else {
         $this->redirect(URL_BASE . "User");
      }
   }

   /*public function importaUsuarios()
   {
      set_time_limit(800);
      $arquivo = URL_BASE.'app/Commands/clientes/Planilha.csv';
      $dados_csv = array_map('str_getcsv', file($arquivo));
      $linhaatual = 0;
      Service::begin_tran();
      try {
          foreach ($dados_csv as $linha) {
               $linhaatual ++;
              $usuario = new \stdClass();      
              $usuario->usuarios_id = 0;
              $usuario->nivel_de_acesso = CLIENTE;
      
              $usuario->email = isset($linha[10])?$linha[10] : '';
              $usuario->senha = 'IZEAS';
              $usuario->usuario = isset($linha[1])?$linha[1] : '';
              $usuario->nome_completo = isset($linha[1])?$linha[1] : '';
              $usuario->fone =isset($linha[8])?$linha[8] : '';
              $usuario->celular = isset($linha[9])?$linha[9] : '';
              $usuario->numero = isset($linha[5])?$linha[5] : '';
              $usuario->rua = isset($linha[4])?$linha[4] : '';
              $usuario->estado = 'SC';
              $usuario->cidade =isset($linha[2])?$linha[2] : '';
              $usuario->complemento = ((isset($linha[6]))?'Ap: '.$linha[6] : '') . ((isset($linha[7]))?' Bloco: '.$linha[7] : '') ;
              $usuario->bairro = isset($linha[3])?$linha[3] : '';      
              $usuario->he_cliente = 1;

              $usuario->nome_fantasia = '';
              $usuario->cpf  = '';
              $usuario->cnpj  = '';
              $usuario->cep  = '';
              $usuario->ie  = '';
              $usuario->rg = '';
          
              
              $usuarios_id = UserService::salvar($usuario, "usuarios_id", "usuarios");
              
              if ($usuarios_id > 0) {
      
              } else {
                  throw new Exception("ERRO AO SALVAR");
              }
              //echo $linhaatual . '<br>';
      
          }
          Service::commit();          
          echo 'FEITO';
      } catch (Exception $e) {
          Service::rollBack();
          echo 'ERRO';
      } 
   }*/
}
