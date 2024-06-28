<?php

namespace app\models\service;

use app\models\validacao\DespesasValidacao;
use app\models\dao\DespesasDao;
use app\util\UtilService;

class DespesasService
{
    const TABELA = "despesas";
    const CAMPO = "despesas_id";

    public static function salvar($despesas, $participantes)
    {
        $validacao = DespesasValidacao::salvar($despesas);

        $despesa = Service::salvar($despesas, self::CAMPO, $validacao->listaErros(), self::TABELA);
        if ($despesa > 1) //se é maior que um inseriu novo 
        {
            
            // Calcular a parte de cada participante
            $parteDeCada = $despesas->valor / count($participantes);

            // Inserir participações na tabela de participations
            foreach ($participantes as $participantes_id) {

                $participantes_despesas = new \stdClass();

                $participantes_despesas->participantes_despesas_id = 0;
                $participantes_despesas->despesas_id = $despesa;
                $participantes_despesas->users_id = $participantes_id;
                $participantes_despesas->devendo_para = $despesas->users_id;
                $participantes_despesas->valor = $parteDeCada;

                Participantes_despesasService::salvar($participantes_despesas);

            }
        }

        return $despesa;
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