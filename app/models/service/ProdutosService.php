<?php

namespace app\models\service;

use app\models\validacao\ProdutosValidacao;
use app\models\dao\ProdutosDao;
use app\util\UtilService;

class ProdutosService
{
    private const TABELA = 'produtos';
    private const CAMPO = 'produtos_id';

    public static function salvarImagemOrçamento($produtos, $campo, $tabela)
    {
        return Service::salvar($produtos, $campo, [], $tabela);
    }

    public static function salvar($produtos)
    {
        $validacao = ProdutosValidacao::salvar($produtos);
        return Service::salvar($produtos, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function produtosOrdenados()
    {        
        $dao = new ProdutosDao();
        return $dao->produtosOrdenados(); 
    } 

    public static function EstoqueInsumo()
    {        
        $dao = new ProdutosDao();
        return $dao->EstoqueInsumo(); 
    }
    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}