<?php

namespace app\models\service;

use app\models\validacao\DespesasValidacao;
use app\models\service\PushService;
use app\models\dao\DespesasDao;
use app\core\Flash;

class DespesasService
{
    const TABELA = "despesas";
    const CAMPO = "despesas_id";

    public static function salvar($despesas, $participantes, $valoresPorParticipante)
    {

        $dao = new DespesasDao();
        if ($dao->jaGravouEssaDespesa($despesas)){
            return 2;    
        }

        $transaction = false;
        if (!Service::inTransaction()) {
            Service::begin_tran();
            $transaction = true;
        }

        try {
            $validacao = DespesasValidacao::salvar($despesas);       

            $despesa = Service::salvar($despesas, self::CAMPO, $validacao->listaErros(), self::TABELA);

            if ($despesa > 1) {
                for ($i = 0; $i < count($participantes); $i++) {
                    $participantes_id = $participantes[$i];
                    $valorPorParticipante = $valoresPorParticipante[$i];

                    $participantes_despesas = new \stdClass();
                    $participantes_despesas->participantes_despesas_id = 0;
                    $participantes_despesas->despesas_id = $despesa;
                    $participantes_despesas->users_id = $participantes_id;
                    $participantes_despesas->devendo_para = $despesas->users_id;
                    $participantes_despesas->valor = $valorPorParticipante;
                    if (Participantes_despesasService::salvar($participantes_despesas) <= 1) {
                        throw new \Exception('ao salvar a despesa do participante: ' . $participantes_id);
                    }

                    $usuarioCadastro = Service::get('users', 'users_id', $_SESSION['id']);
                    if (($participantes_id != $usuarioCadastro->users_id)) {
                        // Se a propriedade 'subscription' está definida, executa o código abaixo
                        $mensagem = 'Despesa ' . $despesas->descricao . ' no valor de ' . moedaBr($valorPorParticipante) . ' adicionada por ' . $usuarioCadastro->username;
                        PushService::push($participantes_id, 'Nova despesa', $mensagem);
                    }
                }
            }
            if ($transaction) {
                service::commit();
            }
            return $despesa;
        } catch (\Exception $e) {
            Flash::setMsg('Erro ' . $e->getMessage(), -1);
            if ($transaction) {
                service::rollback();
            }
            return 0;
        }
    }

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

}