<?php

namespace app\models\service;

use app\models\validacao\Tabela_preco_itemValidacao;
use app\models\dao\Tabela_preco_itemDao;
use app\util\UtilService;

class Tabela_preco_itemService
{
    public static function salvar($tabela_preco_item, $campo, $tabela)
    {
        $validacao = Tabela_preco_itemValidacao::salvar($tabela_preco_item);

        return Service::salvar($tabela_preco_item, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}