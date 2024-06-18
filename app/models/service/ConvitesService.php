<?php

namespace app\models\service;

use app\models\validacao\ConvitesValidacao;
use app\models\dao\ConvitesDao;
use app\util\UtilService;

class ConvitesService
{
    const TABELA = "convites"; 
    const CAMPO = "convites_id";     

    public static function salvar($Convites)
    {
        $validacao = ConvitesValidacao::salvar($Convites);
        
        return Service::salvar($Convites, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new ConvitesDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new ConvitesDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}