<?php

namespace app\models\service;

use app\models\validacao\FaturasValidacao;
use app\models\dao\FaturasDao;
use app\util\UtilService;

class FaturasService
{
    public static function salvar($faturas, $campo, $tabela)
    {
        $validacao = FaturasValidacao::salvar($faturas);

        return Service::salvar($faturas, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}