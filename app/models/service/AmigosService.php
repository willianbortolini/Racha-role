<?php

namespace app\models\service;

use app\models\validacao\AmigosValidacao;
use app\models\dao\AmigosDao;
use app\util\UtilService;

class AmigosService
{
    const TABELA = "amigos"; 
    const CAMPO = "amigos_id";     

    public static function salvar($Amigos)
    {
        $validacao = AmigosValidacao::salvar($Amigos);
        
        return Service::salvar($Amigos, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new AmigosDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new AmigosDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}