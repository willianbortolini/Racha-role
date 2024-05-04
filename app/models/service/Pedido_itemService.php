<?php

namespace app\models\service;

use app\models\validacao\Pedido_itemValidacao;
use app\models\dao\Pedido_itemDao;
use app\util\UtilService;

class Pedido_itemService
{
    public static function salvar($pedido_item, $campo, $tabela)
    {
        $validacao = Pedido_itemValidacao::salvar($pedido_item);

        return Service::salvar($pedido_item, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir('pedido_item_composicao', 'pedido_item_id', $id);
        Service::excluir($tabela, $campo, $id);
    }    
}