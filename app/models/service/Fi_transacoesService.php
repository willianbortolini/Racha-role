<?php

namespace app\models\service;

use app\models\validacao\Fi_transacoesValidacao;
use app\models\dao\Fi_transacoesDao;
use app\util\UtilService;

class Fi_transacoesService
{
    public static function salvar($fi_transacoes, $campo, $tabela)
    {
        $validacao = Fi_transacoesValidacao::salvar($fi_transacoes);

        return Service::salvar($fi_transacoes, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function gastoSemanal($usuario)
    {
        $dao = new Fi_transacoesDao();
        return $dao->gastoSemanal($usuario);
    }

    public static function gastoMensal($usuario)
    {
        $dao = new Fi_transacoesDao();
        return $dao->gastoMensal($usuario);
    }
    
    public static function gastoPorCAtegoriaSemanal($usuario)
    {
        $dao = new Fi_transacoesDao();
        return $dao->gastoPorCategoriaSemanal($usuario);
    }

    public static function gastoPorCategoriaMes($usuario)
    {
        $dao = new Fi_transacoesDao();
        return $dao->gastoPorCategoriaMes($usuario);
    }
    
    public static function CategoriaSemana($usuario,$id_categoria)
    {
        $dao = new Fi_transacoesDao();
        return $dao->CategoriaSemana($usuario,$id_categoria);
    }

    public static function CategoriaMes($usuario,$id_categoria)
    {
        $dao = new Fi_transacoesDao();
        return $dao->CategoriaMes($usuario,$id_categoria);
    }
    

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}