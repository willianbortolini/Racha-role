<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Usuario_acessoService;
use app\core\Flash;
use app\models\service\Service;

class Usuario_acessoController extends Controller
{
    private $tabela = "usuario_acesso";
    private $campo = "usuario_acesso_id";
    private $usuario;

    private $telas = [
        PERMITE_CADASTRARCLIENTENOPEDIDO => 'Permite cadastrar cliente no pedido',
        TELA_FINANCEIRO => 'Financeiro',
            TELA_FINANCEIRO_FATURAS => 'Financeiro->Faturas',
        //TELA_PRODUCAO => 'Produção',
        //    TELA_PRODUCAO_ORDEMDEPRODUCAO => 'Produção->Ordens de produção',
        //    TELA_PRODUCAO_PEDIDOSORDENS => 'Produção->Pedidos ordens de produção',
        //    TELA_PRODUCAO_POSICOESORDEM => 'Produção->Posições ordem',
        //TELA_ESTOQUE => 'Estoque',
        //    TELA_ESTOQUE_CONSULTA => 'Estoque->Consulta',
        //    TELA_ESTOQUE_RESERVAS => 'Estoque->Reservas',
        //    TELA_ESTOQUE_RESERVASPORPEDIDO => 'Estoque->Reservas por pedido',
        //    TELA_ESTOQUE_MOVIMENTACOES => 'Estoque->Movimentações',
        //    TELA_ESTOQUE_MOVIMENTACAOMANUAL => 'Estoque->Movimentação manual',
        TELA_USUARIOS => 'Usuários',
            TELA_USUARIOS_REPRESENTANTES => 'Usuários->Representantes',
            TELA_USUARIOS_CLIENTES => 'Usuários->Clientes',
        //    TELA_USUARIOS_COLABORADORES => 'Usuários->Colaboradores',
        TELA_PRODUTOS => 'Produtos',
            TELA_PRODUTOS_PRODUTOS => 'Produtos->Produtos',
        //    TELA_PRODUTOS_INSUMOS => 'Produtos->Insumos',
            TELA_PRODUTOS_COMPOSICAOPADRAO => 'Produtos->Composição padrão',
            TELA_PRODUTOS_TABELADEPRECO => 'Produtos->Tabela de preço'
    ];

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
        UtilService::validaNivel(ADIMINISTRADOR);
    }

    /*public function index()
    {
        $dados["usuario_acesso"] = Service::lista($this->tabela);
        $dados["view"] = "Usuario_acesso/Show";
        $this->load("templateBootstrap", $dados);
    }*/

    public function usuario($id_usuario)
    {
        $dados["usuario_acesso"] = Usuario_acessoService::acessosDoUsuario($id_usuario);
        $dados["usuarios_id"] = $id_usuario;
        $dados["telas"] = $this->telas;        
        $dados["view"] = "Usuario_acesso/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["usuario_acesso"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Usuario_acesso/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["usuario_acesso"] = Flash::getForm();
        $dados["view"] = "Usuario_acesso/Edit";
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
                Usuario_acessoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            
            if ($_SERVER["REQUEST_METHOD"] === "POST") {  

                foreach ($this->telas as $tela => $valor) {
                    if(isset($_POST[$tela]) and ($_POST[$tela] == 'on')){
                        $usuario_acesso = new \stdClass();
                        $usuario_acesso->usuario_acesso_id = 0;
                        $usuario_acesso->usuarios_id = $_POST["usuarios_id"];
                        $usuario_acesso->acesso = $_POST["acesso"] = $tela;
                        Usuario_acessoService::salvar($usuario_acesso, $this->campo, $this->tabela);
                    }else{
                        Usuario_acessoService::deleteUsuarioAcesso($_POST["usuarios_id"] , $tela);
                    }
                } 
                
       
               
                $this->redirect(URL_BASE   . "Usuario_acesso/usuario/" . $_POST["usuarios_id"]);
            }            
        }
    }

}
