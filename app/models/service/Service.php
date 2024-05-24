<?php

namespace app\models\service;

use app\models\validacao\Validacao;
use app\models\dao\Dao;
use app\util\UtilService;

class Service
{
    public static function salvar($, $campo, $tabela)
    {
        $validacao = Validacao::salvar($);

        return Service::salvar($, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}