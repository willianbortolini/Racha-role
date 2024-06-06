<?php

namespace app\models\service;

use app\models\validacao\SaldosValidacao;
use app\models\dao\SaldosDao;
use app\util\UtilService;

class SaldosService
{
    const TABELA = "saldos"; 
    const CAMPO = "saldos_id";     

    public static function salvar($Saldos)
    {
        $validacao = SaldosValidacao::salvar($Saldos);
        
        return Service::salvar($Saldos, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new SaldosDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new SaldosDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}