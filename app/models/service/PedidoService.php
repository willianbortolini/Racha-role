<?php

namespace app\models\service;

use app\models\validacao\PedidoValidacao;
use app\models\dao\PedidoDao;
use app\core\Flash;
use Exception;
use app\util\UtilService;
use app\models\service\Pedido_itemService;
use app\models\service\Pedido_item_composicaoService;

class PedidoService
{
    public static function listaOrcamentoRepresentante()
    {
        $dao = new PedidoDao();
        return $dao->listaOrcamentoRepresentante();
    }

    public static function listaPedidoRepresentante()
    {
        $dao = new PedidoDao();
        return $dao->listaPedidoRepresentante();
    }

    public static function salvar($pedido, $campo, $tabela)
    {
        $validacao = PedidoValidacao::salvar($pedido);

        return Service::salvar($pedido, $campo, $validacao->listaErros(), $tabela);

    }

    public static function copiarPedido($pedidos_id)
    {
        $colunasDePedidos = Service::colunasDaTabela('pedidos');
        $pedido = Service::get('pedidos', 'pedidos_id', $pedidos_id);
        $pedidoCopia = new \stdClass();

        foreach ($colunasDePedidos as $coluna) {
            if ($coluna->COLUMN_NAME == 'pedidos_id') {
                $pedidoCopia->{$coluna->COLUMN_NAME} = 0;
            } else if ($coluna->COLUMN_NAME == 'pedidos_nome') {
                $pedidoCopia->{$coluna->COLUMN_NAME} = 'Cópia de :' . $pedido->{$coluna->COLUMN_NAME};
            } else if ($coluna->COLUMN_NAME == 'pedido_dataCriacao') {
                $pedidoCopia->{$coluna->COLUMN_NAME} = date("Y-m-d H:i:s");
            } else if ($coluna->COLUMN_NAME == 'codigo_acesso_cliente') {
                $pedidoCopia->{$coluna->COLUMN_NAME} = uniqid();
            } else if ($coluna->COLUMN_NAME == 'statusPedido_id') {
                $pedidoCopia->{$coluna->COLUMN_NAME} = ORCAMENTO;
            } else {
                $pedidoCopia->{$coluna->COLUMN_NAME} = $pedido->{$coluna->COLUMN_NAME};
            }
        }
        //aqui tem que salvar o pedido
        $novoPedidos_id = self::salvar($pedidoCopia,'pedidos_id', 'pedidos');
        if ($novoPedidos_id == 0){
            Flash::setMsg("Não foi possovel copiar o pedido", -1);
            throw new Exception("Erro ao copiar o pedido.");
        }

        $itensDoPedido = Service::get('pedido_item', 'pedidos_id', $pedidos_id, true);
        $colunasDePedido_item = Service::colunasDaTabela('pedido_item');       
        foreach ($itensDoPedido as $itens) {
            $pedido_itemCopia = new \stdClass();
            foreach ($colunasDePedido_item as $coluna) {
                if ($coluna->COLUMN_NAME == 'pedido_item_id') {
                    $pedido_itemCopia->{$coluna->COLUMN_NAME} = 0;
                } else if ($coluna->COLUMN_NAME == 'pedidos_id') {  
                    $pedido_itemCopia->{$coluna->COLUMN_NAME} = $novoPedidos_id;  
                } else {
                    $pedido_itemCopia->{$coluna->COLUMN_NAME} = $itens->{$coluna->COLUMN_NAME};
                }
            }

            //aqui salva o item            
            $novoPedido_Item = Pedido_itemService::salvar($pedido_itemCopia, 'pedido_item_id', 'pedido_item');
            if ($novoPedido_Item == 0){
                Flash::setMsg("Não foi possovel copiar o pedido", -1);
                throw new Exception("Erro ao copiar o pedido.");
            }

            $composicaoDoItem = Service::get('pedido_item_composicao', 'pedido_item_id', $itens->pedido_item_id, true);
            $colunasDeComposicao = Service::colunasDaTabela('pedido_item_composicao'); 
            foreach ($composicaoDoItem as $composicao) {
                $composicaoItem = new \stdClass();
                foreach ($colunasDeComposicao as $coluna) {
                    if ($coluna->COLUMN_NAME == 'pedido_item_composicao_id') {
                        $composicaoItem->{$coluna->COLUMN_NAME} = 0;
                    } else if ($coluna->COLUMN_NAME == 'pedido_item_id') {  
                        $composicaoItem->{$coluna->COLUMN_NAME} = $novoPedido_Item;  
                    } else {
                        $composicaoItem->{$coluna->COLUMN_NAME} = $composicao->{$coluna->COLUMN_NAME};
                    }
                }
                $pedidoItemComposicao = Pedido_item_composicaoService::salvar($composicaoItem, 'pedido_item_composicao_id', 'pedido_item_composicao'); 
                if ($pedidoItemComposicao == 0){
                    Flash::setMsg("Não foi possovel copiar o pedido", -1);
                    throw new Exception("Erro ao copiar o pedido.");
                }
            }
            
        }
    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }

}

