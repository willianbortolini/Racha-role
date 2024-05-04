<?php

namespace app\models\service;

use app\models\validacao\Ordem_producaoValidacao;
use app\models\dao\Ordem_producaoDao;
use app\models\service\Ordem_producao_itemService;
use app\models\service\ReservaService;
use app\util\UtilService;

class Ordem_producaoService
{
    private const CAMPO = 'ordem_producao_id';
    private const TABELA = 'ordem_producao';

    public static function salvar($ordem_producao)
    {
        $validacao = Ordem_producaoValidacao::salvar($ordem_producao);
        return Service::salvar($ordem_producao, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }

    public static function conteudoDaPosicaoDosItensNaOp($ordem_producao_id)
    {
        $dao = new Ordem_producaoDao;
        return $dao->conteudoDaPosicaoDosItensNaOp($ordem_producao_id);
    }

    public static function produtosReservadosParaOP($ordem_producao_id)
    {
        $dao = new Ordem_producaoDao;
        return $dao->produtosReservadosParaOP($ordem_producao_id);
    }

    public static function excluir($id)
    {
        Ordem_producao_itemService::excluirOP($id);
        ReservaService::excluirOP($id);
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function excluirComPedido($pedidos_id)
    {
        $id = Service::get(self::TABELA, 'pedidos_id', $pedidos_id)->ordem_producao_id;
        Ordem_producao_itemService::excluirOP($id);
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function criarOsComPedido($pedido_id)
    {
        $ordem_producao = new \stdClass();
        $ordem_producao->ordem_producao_id = 0;
        $ordem_producao->pedidos_id = $pedido_id;

        $dataAtual = date("Y-m-d H:i:s");
        $dataMaisDuasSemanas = new \DateTime($dataAtual);
        $dataMaisDuasSemanas->add(new \DateInterval('P2W'));

        $ordem_producao->data_confirmacao_pedido = date("Y-m-d H:i:s");
        $ordem_producao->data_limite_producao = $dataMaisDuasSemanas->format('Y-m-d H:i:s');
        $ordem_producao->data_limite_instalcao = $dataMaisDuasSemanas->format('Y-m-d H:i:s');
        $ordem_producao->empresa = 2;

        self::salvar($ordem_producao);
        Ordem_producao_itemService::criaItensOsComPedido($pedido_id);
    }

    public static function Finaliza($ordem_producao_id)
    {
        $ordem_producao = new \stdClass();
        $ordem_producao->ordem_producao_id = $ordem_producao_id;
        $ordem_producao->data_finalizacao = date("Y-m-d H:i:s");
        self::salvar($ordem_producao);

        $produtosReservados = self::produtosReservadosParaOP($ordem_producao_id);

        ReservaService::liberarReservasDeDocumento(RESERVA_OP, $ordem_producao_id);
        
       foreach ($produtosReservados as $produto) {
            Movimentacao_estoqueService::saidaEstoque($produto->produtos_id, $produto->quantidade, $produto->reserva_id);
        }

    }
}