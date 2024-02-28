<?php

namespace app\models\service;

use app\models\validacao\InventarioValidacao;
use app\models\dao\InventarioDao;
use app\util\UtilService;

class InventarioService
{
    public static function salvar($inventario, $campo, $tabela)
    {
        $validacao = InventarioValidacao::salvar($inventario);

        return Service::salvar($inventario, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}