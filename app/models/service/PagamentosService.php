<?php

namespace app\models\service;

use app\models\validacao\PagamentosValidacao;
use app\models\dao\PagamentosDao;
use app\util\UtilService;

class PagamentosService
{
    const TABELA = "pagamentos"; 
    const CAMPO = "pagamentos_id";     

    public static function salvar($Pagamentos)
    {
        $validacao = PagamentosValidacao::salvar($Pagamentos);
        
        return Service::salvar($Pagamentos, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new PagamentosDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new PagamentosDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}