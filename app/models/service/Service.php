<?php

namespace app\models\service;

use app\models\validacao\Validacao;
use app\models\dao\Dao;
use app\util\UtilService;

class Service
{
    const TABELA = ""; 
    const CAMPO = "_id";     

    public static function salvar($)
    {
        $validacao = Validacao::salvar($);
        
        return Service::salvar($, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new Dao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new Dao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}