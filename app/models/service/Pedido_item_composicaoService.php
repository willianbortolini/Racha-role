<?php

namespace app\models\service;

use app\models\validacao\Pedido_item_composicaoValidacao;
use app\models\dao\Pedido_item_composicaoDao;
use app\util\UtilService;

class Pedido_item_composicaoService
{
    public static function salvar($pedido_item_composicao, $campo, $tabela)
    {
        $validacao = Pedido_item_composicaoValidacao::salvar($pedido_item_composicao);

        return Service::salvar($pedido_item_composicao, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}