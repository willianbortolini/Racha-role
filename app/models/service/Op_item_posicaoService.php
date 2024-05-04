<?php

namespace app\models\service;

use app\models\validacao\Op_item_posicaoValidacao;
use app\models\dao\Op_item_posicaoDao;

class Op_item_posicaoService
{
    public static function salvar($op_item_posicao, $campo, $tabela)
    {
        $validacao = Op_item_posicaoValidacao::salvar($op_item_posicao);

        return Service::salvar($op_item_posicao, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function posicoesOrdenaras()
    {
        $dao = new Op_item_posicaoDao;
        return $dao->posicoesOrdenaras();
    }
    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}