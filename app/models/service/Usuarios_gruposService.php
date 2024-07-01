<?php

namespace app\models\service;

use app\models\validacao\Usuarios_gruposValidacao;
use app\models\dao\Usuarios_gruposDao;
use app\util\UtilService;

class Usuarios_gruposService
{
    const TABELA = "usuarios_grupos"; 
    const CAMPO = "usuarios_grupos_id";     

    public static function salvar($Usuarios_grupos)
    {
        $validacao = Usuarios_gruposValidacao::salvar($Usuarios_grupos);
        
        return Service::salvar($Usuarios_grupos, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new Usuarios_gruposDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new Usuarios_gruposDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }

    public static function membrosDoGrupo($grupos_id)
    {
        $dao = new Usuarios_gruposDao();
        return $dao->membrosDoGrupo($grupos_id);
    }
}