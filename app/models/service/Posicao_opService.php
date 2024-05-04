<?php

namespace app\models\service;

use app\models\validacao\Posicao_opValidacao;
use app\models\dao\Posicao_opDao;
use app\util\UtilService;

class Posicao_opService
{
    public static function salvar($posicao_op, $campo, $tabela)
    {
        $validacao = Posicao_opValidacao::salvar($posicao_op);

        return Service::salvar($posicao_op, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}