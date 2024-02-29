<?php

namespace app\models\service;

use app\models\validacao\Inventario_itemValidacao;
use app\models\dao\Inventario_itemDao;
use app\util\UtilService;

class Inventario_itemService
{
    public static function salvar($inventario_item, $campo, $tabela)
    {
        $validacao = Inventario_itemValidacao::salvar($inventario_item);

        return Service::salvar($inventario_item, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function identiradesContadas($inventarios_id)
    {
        $dao = new Inventario_itemDao();
        return $dao->identiradesContadas($inventarios_id);
    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}