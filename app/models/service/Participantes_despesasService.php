<?php

namespace app\models\service;

use app\models\validacao\Participantes_despesasValidacao;
use app\models\dao\Participantes_despesasDao;
use app\util\UtilService;

class Participantes_despesasService
{
    const TABELA = "participantes_despesas"; 
    const CAMPO = "participantes_despesas_id";     

    public static function salvar($Participantes_despesas)
    {
        $validacao = Participantes_despesasValidacao::salvar($Participantes_despesas);
        
        return Service::salvar($Participantes_despesas, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new Participantes_despesasDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new Participantes_despesasDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}