<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\UsersService;
use app\core\Flash;
use app\models\service\Service;
use app\models\service\LoginService;

class UsersController extends Controller
{
    private $tabela = "users";
    private $campo = "users_id";


    /*public function __construct()
    {
        UtilService::validaUsuario();
    }*/

    public function edit($id)
    {
        UtilService::usuarioAutorizado($id);
        $dados["users"] = Service::get($this->tabela, $this->campo, $id);
        $dados["btnAtivo"] = "perfil";
        $dados["view"] = "Users/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["users"] = Flash::getForm();
        $dados["view"] = "Users/Create";
        $this->load("template", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                UtilService::usuarioAutorizado($id);
                // Excluir a imagem, se existir               
                $existe_imagem = service::get($this->tabela, $this->campo, $id);
                if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->foto_perfil);
                }

                // Excluir
                UsersService::excluir($id);
            }
        }
    }
    /*
        public function list()
        {
            $dados_requisicao = $_REQUEST;

            // Lista de colunas da tabela
            $colunas = [
             0 => 'users_id',
             1 => 'username',
             2 => 'email',
             3 => 'telefone'
            ];

            if (!empty($dados_requisicao['search']['value'])) {
                $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
            } else {
                $valor_pesquisa = "";
            }
            $row_qnt_usuarios = UsersService::quantidadeDeLinhas($valor_pesquisa);

            $parametros = [
                'inicio' => intval($dados_requisicao['start']),
                'quantidade' => intval($dados_requisicao['length']),
                'colunaOrder' => $colunas[$dados_requisicao['order'][0]['column']],
                'direcaoOrdenacao' => $dados_requisicao['order'][0]['dir'],
                'valor_pesquisa' => $valor_pesquisa
            ];
            $listaRetorno = UsersService::lista($parametros);
            $dados = [];
            foreach ($listaRetorno as $coluna) {
                $registro = [];
                $registro[] = $coluna->users_id;
                $registro[] = $coluna->username;
                $registro[] = $coluna->email;
                $registro[] = $coluna->telefone;
                $registro[] = "<a href='" . URL_BASE . "Users/edit/" . $coluna->users_id . "' class='btn btn-primary btn-sm mt-2'>Editar</a>
                <button onclick='deletarItem(" . $coluna->users_id . ")' type='button'
                    class='btn btn-danger btn-sm mt-2' data-bs-toggle='modal'
                    data-bs-target='#deleteModal'>
                    Deletar
                </button>";
                $dados[] = $registro;
            }

            $resultado = [
                "draw" => intval($dados_requisicao['draw']),
                "recordsTotal" => $row_qnt_usuarios->total,
                "recordsFiltered" => $row_qnt_usuarios->total,
                "data" => $dados
            ];

            echo json_encode($resultado);
        }
    */
    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $users = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["users_id"]) && is_numeric($_POST["users_id"]) && $_POST["users_id"] > 0) {
                    $users->users_id = $_POST["users_id"];
                    UtilService::usuarioAutorizado($users->users_id);
                } else {
                    throw new \Exception("Não autorizado", 401);
                }
                if (isset($_POST["username"]))
                    $users->username = $_POST["username"];
                if (isset($_POST["email"]))
                    $users->email = $_POST["email"];
                if (isset($_POST["telefone"]))
                    $users->telefone = $_POST["telefone"];
                if (isset($_POST['politica']))
                    $users->politica = ($_POST['politica'] == 'on') ? 1 : 0;
                if (isset($_POST['cookies']))
                    $users->cookies = ($_POST['cookies'] == 'on') ? 1 : 0;

            }

            Flash::setForm($users);
            if (UsersService::salvar($users) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Users");
            } else {
                if (!$users->users_id) {
                    $this->redirect(URL_BASE . "Users/create");
                } else {
                    $this->redirect(URL_BASE . "Users/edit/" . $users->users_id);
                }
            }
        }
    }

    public function desativar()
    {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $users = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $users->users_id = $id;
                $users->ativo = 0;
            }
            if (UsersService::ativo($users) > 0) 
            {
                Flash::setMsg("Perfil desativado", 1);      
            }
            $this->redirect(URL_BASE . "Users/edit/" . $users->users_id);

        } else {
            Flash::setMsg("Erro na tentativa de desativar o perfil", -1);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function ativar()
    {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $users = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $users->users_id = $id;
                $users->ativo = 1;
            }
            if (UsersService::ativo($users) > 0)
            {
                Flash::setMsg("Perfil reativado", 1);      
            }
            $this->redirect(URL_BASE . "Users/edit/" . $users->users_id);

        } else {
            Flash::setMsg("Erro na tentativa de desativar o perfil", -1);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }


    public function criar()
    {
        $User = new \stdClass();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $User->users_id = 0;
            if (isset($_POST["email"]))
                $User->email = $_POST["email"];
            if (isset($_POST["password"]))
                $User->password = $_POST['password'];
            if (isset($_POST["confirmacao"]))
                $User->confirmacao = $_POST['confirmacao'];
            $User->politica = (isset($_POST['politica']) && $_POST['politica'] == 'on') ? 1 : 0;
            $User->cookies = (isset($_POST['cookies']) && $_POST['cookies'] == 'on') ? 1 : 0;

            Flash::setForm($User);

            if (UsersService::criar($User)) {
                $retornoUsusario = LoginService::login($User->email, $_POST['password']);
                if ($retornoUsusario == 1) {
                    Flash::limpaErro();
                    Flash::limpaMsg();
                    $this->redirect(URL_BASE);
                } else {
                    $dados["erro"] = "Email ou senha invalidos";
                    $this->load("login", $dados);
                }
            } else {
                $this->redirect(URL_BASE . "Users/Create");
            }
        }
    }

}
