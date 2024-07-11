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
    
    public static function editar($Participantes_despesas)
    {
        $validacao = [];
        return Service::salvar($Participantes_despesas, self::CAMPO, $validacao, self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function meusDebitosEmAberto($users_id)
    {
        $dao = new Participantes_despesasDao();
        return $dao->meusDebitosEmAberto($users_id);
    }

    public static function meusValoresAReceber($users_id)
    {
        $dao = new Participantes_despesasDao();
        return $dao->meusValoresAReceber($users_id);
    }

    public static function meusValoresPorGrupo($users_id)
    {
        $dao = new Participantes_despesasDao();
        return $dao->meusValoresPorGrupo($users_id);
    }
    public static function dividaEntreUsuarios($devedor, $credor)
    {
        $dao = new Participantes_despesasDao();
        return $dao->dividasEntreUsuarios($devedor, $credor);
    }

    public static function totalDividasEntreUsuarios($devedor, $credor)
    {
        $dao = new Participantes_despesasDao();
        return $dao->totalDividasEntreUsuarios($devedor, $credor);
    }

    public static function resumoValoresAmigos($users_id)
    {
        $dao = new Participantes_despesasDao();
        return $dao->resumoValoresAmigos($users_id);
    }

    public static function saldoUsuario($users_id)
    {
        $dao = new Participantes_despesasDao();
        return $dao->saldoUsuario($users_id);
    }

    public static function negociacoesEntreDoisUsuarios($eu, $outro, $inicio = null, $fim = null)
    {
        $dao = new Participantes_despesasDao();
        return $dao->negociacoesEntreDoisUsuarios($eu, $outro, $inicio = null, $fim = null);
    } 
    
    
}