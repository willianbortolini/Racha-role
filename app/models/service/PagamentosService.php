<?php

namespace app\models\service;

use app\models\validacao\PagamentosValidacao;
use app\models\dao\PagamentosDao;
use app\util\UtilService;

class PagamentosService
{
    const TABELA = "pagamentos";
    const CAMPO = "pagamentos_id";

    public static function salvar($pagamentos)
    {
        $validacao = PagamentosValidacao::salvar($pagamentos);

        $resposta = Service::salvar($pagamentos, self::CAMPO, $validacao->listaErros(), self::TABELA);
        if ($resposta > 1) {
            $valorRestante = $pagamentos->valor;
            $valoresPendentes = Participantes_despesasService::dividaEntreUsuarios($pagamentos->pagador, $pagamentos->recebedor);
            foreach ($valoresPendentes as $valor) {
                if ($valorRestante > 0) {
                    $participantes_despesas = new \stdClass();
                    $participantes_despesas->participantes_despesas_id = $valor->participantes_despesas_id;

                    if ($valor->valor - $valor->valor_pago <= $valorRestante) {
                        $participantes_despesas->valor_pago = $valor->valor;
                        $valorRestante -= ($valor->valor - $valor->valor_pago);
                    } else {
                        $participantes_despesas->valor_pago = $valor->valor_pago + $valorRestante;
                        $valorRestante = 0;
                    }
                    $Participantes_despesa = Participantes_despesasService::editar($participantes_despesas);
                    if ($Participantes_despesa <> 1) {
                        throw new \Exception();
                    }
                }
            }

            //se sobrou saldo faz uma nova despesa com a quantidade restante
            if ($valorRestante > 0) {
                $despesas = new \stdClass();
                $despesas->despesas_id = 0;
                $despesas->descricao = "Sobra do pagamento";
                $despesas->valor = $valorRestante;
                $despesas->data = date('Y-m-d H:i:s');
                $despesas->users_id = $pagamentos->pagador;
                $participantes = [$pagamentos->recebedor];

                $despesa = DespesasService::salvar($despesas, $participantes);

                if ($despesa < 1) {
                    throw new \Exception();
                }
            }
        }
        return $resposta;
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