<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\PedidoService;
use app\core\Flash;
use app\models\service\Pedido_itemService;
use app\models\service\Service;
use app\models\service\ProdutosService;
use app\models\service\Ordem_producaoService;
use Exception;

class PedidoController extends Controller
{
    private $tabela = "pedidos";
    private $campo = "pedidos_id";
    private $usuario;

    private function validaLogin()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        $this->validaLogin();
        $dados["pedidos"] = Service::get('vw_pedidos', 'usuarios_id', $_SESSION['id'], true);
        $dados["view"] = "Pedido/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $this->validaLogin();
        $dados["markupSugerido"] = Service::get('usuarios', 'usuarios_id', $_SESSION['id'])->usuarios_markup;
        $dados["produtos"] = ProdutosService::produtosOrdenados();
        $dados["pedidos"] = Service::get('vw_pedidos', $this->campo, $id);
        if($dados["pedidos"]->statusPedido_id == ORCAMENTO){
            $dados['titulo'] = 'Orçamento ' . $id;
        }else{
            $dados['titulo'] = 'Pedido ' . $id;
        }
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $id, true);
        $dados["usuarios"] = Service::get('usuarios', 'he_representante', 1, true);
        $dados["clientes"] = Service::get('usuarios', 'he_cliente', 1, true);
        $dados["view"] = "Pedido/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function visualizar($pedido_id)
    {
        $dados["pedidos"] = Service::get('vw_pedidos', $this->campo, $pedido_id);
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $pedido_id, true);
        $dados["view"] = "Pedido/Visualizar";
        $this->load("templateBootstrap", $dados);
    }

    public function print($id)
    {
        $this->validaLogin();
        $dados["pedidos"] = Service::get('vw_pedidos', $this->campo, $id);
        $dados["usuario"] = Service::get('usuarios', 'usuarios_id', $dados["pedidos"]->usuarios_id);
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $id, true);
        $produtos_imagem = [];
        foreach ($dados["pedido_item"] as $item) {
            if (isset($item->produtos_id)) {
                $produtos_imagem[] = $item->imagem_produto;
            }
        }
        $dados["imagem_produto"] = $produtos_imagem;
        $dados["view"] = "Pedido/Print";
        $this->load("template", $dados);
    }

    public function cliente($codigo_acesso)
    {
        $dados["pedidos"] = Service::get('vw_pedidos', 'codigo_acesso_cliente', $codigo_acesso);
        $dados["usuario"] = Service::get('usuarios', 'usuarios_id', $dados["pedidos"]->usuarios_id);
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $dados["pedidos"]->pedidos_id, true);
        $produtos_imagem = [];
        foreach ($dados["pedido_item"] as $item) {
            if (isset($item->produtos_id)) {
                $produtos_imagem[] = $item->imagem_produto;
            }
        }
        $dados["imagem_produto"] = $produtos_imagem;
        $dados["view"] = "Pedido/Print";
        $this->load("template", $dados);
    }

    public function email($id)
    {
        $dados["pedidos"] = Service::get('vw_pedidos', $this->campo, $id);
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $id, true);
        $dados["view"] = "Pedido/Email";
        $this->load("Pedido/Email", $dados);
    }

    public function visualizar_pedido_representante($id)
    {
        $dados["pedidos"] = Service::get('vw_pedidos', $this->campo, $id);
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $id, true);
        $dados["view"] = "Pedido/PedidoVisualizar";
        $this->load("templateBootstrap", $dados);
    }

    public function create($id)
    {
        $this->validaLogin();
        $dados["pedidos"] = Service::get($this->tabela, $this->campo, $id);
        $dados["pedido_item"] = Service::get('vw_pedido_item', 'pedidos_id', $id, true);
        $dados["view"] = "Pedido/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        $this->validaLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                Pedido_itemService::excluir('pedido_item', 'pedidos_id', $id);
                PedidoService::excluir($this->tabela, $this->campo, $id);

            }
        }
    }

    public function copiarPedido($pedidos_id)
    {
        Service::begin_tran();
        try {
            PedidoService::copiarPedido($pedidos_id);
            Service::commit();
        } catch (Exception $e) {
            Flash::setMsg("ERRO:". $e->getMessage(),-1);
            Service::rollBack();
        } finally {
           $this->redirect(URL_BASE);
        }
        
    }



    public function save()
    {
        $this->validaLogin();
        $statusAnterior = 0;
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $pedido = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["pedidos_id"]) && is_numeric($_POST["pedidos_id"]) && $_POST["pedidos_id"] > 0) {
                    $pedido->pedidos_id = $_POST["pedidos_id"];
                } else {
                    $pedido->pedidos_id = 0;
                    $pedido->usuarios_id = $_SESSION['id'];
                    $pedido->pedido_dataCriacao = dataHoraSP();
                    $pedido->statusPedido_id = ORCAMENTO;
                }
                if (isset($_POST["usuarios_id"]))
                    $pedido->usuarios_id = $_POST["usuarios_id"];
                if (isset($_POST["statusPedido_id"]))
                    $pedido->statusPedido_id = $_POST["statusPedido_id"];
                if (isset($_POST["pedidos_nome"]))
                    $pedido->pedidos_nome = $_POST["pedidos_nome"];
                    if (isset($_POST["cliente"]))
                    $pedido->cliente = $_POST["cliente"];
                //cria uma chave de acesso
                if (!isset($_POST["codigo_acesso_cliente"])) {
                    $pedido->codigo_acesso_cliente = uniqid();
                }
                
                if ($pedido->pedidos_id > 0) {
                    $pedidoAntesDeEditar = Service::get($this->tabela, $this->campo, $pedido->pedidos_id);
                    $statusAnterior = $pedidoAntesDeEditar->statusPedido_id;
                }
                if (($statusAnterior == PEDIDO)&&($pedido->statusPedido_id == PEDIDO_APROVADO)) {
                    $pedido->data_aprovacao = date("Y-m-d H:i:s");
                }
                if (($statusAnterior == ORCAMENTO)&&($pedido->statusPedido_id == PEDIDO)) { 
                    $pedido->data_pedido = date("Y-m-d H:i:s");
                }
            }

            Flash::setForm($pedido);
            $pedido_id = PedidoService::salvar($pedido, $this->campo, $this->tabela);
            if ($pedido_id > 1) //se é maior que um inseriu novo 
            {
                Flash::limpaMsg();
                $this->redirect(URL_BASE . "Pedido/edit/" . $pedido_id);
            } else  if ($pedido_id == 1){
                if (!$pedido->pedidos_id) {
                    $this->redirect(URL_BASE . "Pedido/create");
                } else {
                    if (($statusAnterior == ORCAMENTO)&&($pedido->statusPedido_id == PEDIDO)) {                        
                        $adiministrador = Service::get('usuarios', 'he_administrador', 1);
                        $emailAdministrador = $adiministrador->email;
                        $administradosRecebeEmail = $adiministrador->receber_email;
                        if ($administradosRecebeEmail > 0) {                            
                            $conteudo = file_get_contents(URL_BASE . 'Pedido/email/' . $pedido->pedidos_id);
                            service::email(
                                $emailAdministrador,
                                'Novo Pedido adicionado',
                                $conteudo,
                                'orcamento@w9b2.com',
                                'noreply@w.com'
                            );
                        }
                    }
                    if (($statusAnterior == PEDIDO)&&($pedido->statusPedido_id == ORCAMENTO)) {  
                        $adiministrador = Service::get('usuarios', 'he_administrador', 1);
                        $emailAdministrador = $adiministrador->email;
                        $administradosRecebeEmail = $adiministrador->receber_email;
                        if ($administradosRecebeEmail > 0) {                            
                            $conteudo = file_get_contents(URL_BASE . 'Pedido/email/' . $pedido->pedidos_id);
                            service::email(
                                'O pedido numero '.$pedido->pedidos_id.' foi retornado para o status orçamento.',
                                'Pedido calcelado',
                                $conteudo,
                                'orcamento@w9b2.com',
                                'noreply@w.com'
                            );
                        }
                    }
                    if (($statusAnterior == PEDIDO)&&($pedido->statusPedido_id == PEDIDO_APROVADO)) {
                        Ordem_producaoService::criarOsComPedido($pedido->pedidos_id); 
                    }
                    if (($statusAnterior == PEDIDO_APROVADO)&&($pedido->statusPedido_id == PEDIDO)) {
                        Ordem_producaoService::excluirComPedido($pedido->pedidos_id);                        
                    }
                    $this->redirect(URL_BASE . "Pedido/edit/" . $pedido->pedidos_id);
                }
            }
        }
    }


}
