<?php

namespace app\models\service;

use app\models\validacao\DespesasValidacao;
use app\models\dao\DespesasDao;
use app\util\UtilService;

class DespesasService
{
    const TABELA = "despesas"; 
    const CAMPO = "despesas_id";     

    public static function salvar($Despesas)
    {
        $validacao = DespesasValidacao::salvar($Despesas);
        
        return Service::salvar($Despesas, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new DespesasDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new DespesasDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}