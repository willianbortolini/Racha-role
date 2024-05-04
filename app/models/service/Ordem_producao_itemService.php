<?php

namespace app\models\service;

use app\core\Flash;
use app\models\validacao\Ordem_producao_itemValidacao;
use app\models\dao\Ordem_producao_itemDao;
use app\models\service\ReservaService;
use app\util\UtilService;
use Exception;

class Ordem_producao_itemService
{
    private $tabela = "ordem_producao_item";
    private $campo = "ordem_producao_item_id";
    public static function salvar($ordem_producao_item, $campo, $tabela)
    {
        $validacao = Ordem_producao_itemValidacao::salvar($ordem_producao_item);

        return Service::salvar($ordem_producao_item, $campo, $validacao->listaErros(), $tabela);

    }

    public static function posicoesOpParaItemPedido($pedido_item_id)
    {
        $dao = new Ordem_producao_itemDao;
        return $dao->posicoesOpParaItemPedido($pedido_item_id);
    }
    public static function insumosUtilizadosNaOpPorItemDoPedido($pedido_item_id)
    {
        $dao = new Ordem_producao_itemDao;
        return $dao->insumosUtilizadosNaOpPorItemDoPedido($pedido_item_id);
    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }

    public static function excluirOP($ordem_producao_id)
    {
        Ordem_producao_itemService::excluir('ordem_producao_item', 'ordem_producao_id', $ordem_producao_id);
    }

    public static function criaItensOsComPedido($pedidos_id)
    {
        $pdo = Service::getDBConnection();

        $itensPedido = Service::get('vw_pedido_item', 'pedidos_id', $pedidos_id, true);
        $ordemProducao = Service::get('ordem_producao', 'pedidos_id', $pedidos_id);
        $quantidadesPorInsumo = array();
        foreach ($itensPedido as $itens) {
            if (isset($itens->produtos_id)) {
                $ordem_producao_item = new \stdClass();
                $ordem_producao_item->ordem_producao_item_id = 0;
                $ordem_producao_item->ordem_producao_id = $ordemProducao->ordem_producao_id;
                $ordem_producao_item->ambiente = $itens->pedido_item_descricao;
                $ordem_producao_item->modelo = $itens->produtos_id;
                $ordem_producao_item->largura = $itens->pedido_item_largura;
                $ordem_producao_item->altura = $itens->pedido_item_altura;
                $ordem_producao_item->pedido_item_id = $itens->pedido_item_id;
                $ordem_producao_item->quantidade = $itens->pedido_item_quantidade;

                $largura = $ordem_producao_item->largura;
                $altura = $ordem_producao_item->altura;
                $quantidade = $itens->pedido_item_quantidade;
                $ordem_producao_item_id = Ordem_producao_itemService::salvar($ordem_producao_item, "ordem_producao_item_id", "ordem_producao_item");

                if ($ordem_producao_item_id > 1) //se é maior que um inseriu novo 
                {
                    $posicoes_item = Ordem_producao_itemService::posicoesOpParaItemPedido($itens->pedido_item_id);
                    foreach ($posicoes_item as $posicao) {
                        $op_item_posicao = new \stdClass();
                        $op_item_posicao->op_item_posicao_id = 0;
                        $op_item_posicao->posicao_op_id = $posicao->posicao_op_id;
                        $op_item_posicao->ordem_producao_item_id = $ordem_producao_item_id;

                        //string OP                         
                        $valor = $posicao->pedido_item_composicao_valor;
                        $stringOP = $posicao->composicao_op_formula;
                        if (strpos($stringOP, '{') !== false && strpos($stringOP, '}') !== false) {
                            preg_match('/{([^}]+)}/', $stringOP, $matches);
                            $formula = $matches[1];
                            $formulaSubstituida = str_replace(['l', 'a', 'v', 'q', ','], [$largura, $altura, $valor, $quantidade, '.'], $formula);
                            $resultado = eval ("return $formulaSubstituida;");
                            $stringOP = str_replace($matches[0], $resultado, $stringOP);
                        }
                        if ($posicao->texto != '') {
                            $op_item_posicao->conteudo_op_item = "|adicionado manual| " . $posicao->texto;
                        } else {
                            $op_item_posicao->conteudo_op_item = $stringOP;
                        }
                        Op_item_posicaoService::salvar($op_item_posicao, 'op_item_posicao_id', 'op_item_posicao');
                    }

                    $insumos = Ordem_producao_itemService::insumosUtilizadosNaOpPorItemDoPedido($itens->pedido_item_id);
                    foreach ($insumos as $insumo) {
                        // Calcula a quantidade de insumo
                        $formulaSubstituida = str_replace(['l', 'a', 'v', ','], [$largura, $altura, $valor, '.'], $insumo->quantidade_insumo);
                        $resultado = eval ("return $formulaSubstituida;");
                        $quantidadeInsumo = $resultado * $quantidade;

                        // Se o insumo já existe no array associativo, adiciona a quantidade
                        // Se não, cria uma nova entrada no array associativo
                        if (isset($quantidadesPorInsumo[$insumo->insumo])) {
                            $quantidadesPorInsumo[$insumo->insumo]['quantidadeInsumo'] += $quantidadeInsumo;
                        } else {
                            $quantidadesPorInsumo[$insumo->insumo] = array(
                                'insumo' => $insumo->insumo,
                                'produtos_nome' => $insumo->produtos_nome,
                                'quantidadeInsumo' => $quantidadeInsumo,
                                'estoque_quantidade' => $insumo->estoque_quantidade,
                                'quantidade_reservada' => $insumo->quantidade_reservada
                            );
                            ;
                        }
                    }                   
                }
            }
        }

         //reserva estoque
         foreach ($quantidadesPorInsumo as $insumo) {
            /* if ($insumo['estoque_quantidade'] - $insumo['quantidade_reservada'] < $insumo['quantidadeInsumo']) {
                 Flash::setMsg("" . $insumo['produtos_nome'] . " sem estoque suficiente, necessario= " . $insumo['quantidadeInsumo'] . ", disponível= " . $insumo['estoque_quantidade'] - $insumo['quantidade_reservada'], -1);
                 throw new Exception("Item sem estoque");
             }*/
             $reserva = new \stdClass();
             $reserva->reserva_id = 0;
             $reserva->produtos_id = $insumo['insumo'];
             $reserva->quantidade = $insumo['quantidadeInsumo'];
             $reserva->tipo = RESERVA_OP;
             $reserva->reservado = 1;
             $reserva->documento = $ordemProducao->ordem_producao_id;
             $reserva->descricao = "OP " . $ordemProducao->ordem_producao_id;
             if (ReservaService::salvar($reserva) < 1) {
                 Flash::setMsg("erro ao inserir reserva.", -1);
                 throw new Exception("erro ao inserir reserva.");
             }
         }
    }



}
