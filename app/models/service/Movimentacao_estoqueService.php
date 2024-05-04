<?php

namespace app\models\service;

use app\models\validacao\Movimentacao_estoqueValidacao;
use app\core\Flash;
use Exception;
use app\models\dao\Movimentacao_estoqueDao;
use app\models\service\ProdutosService;

class Movimentacao_estoqueService
{
    const TABELA = "movimentacao_estoque";
    const CAMPO = "movimentacao_estoque_id";
    public static function salvar($movimentacao_estoque)
    {
        $validacao = Movimentacao_estoqueValidacao::salvar($movimentacao_estoque);
        return Service::salvar($movimentacao_estoque, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }

    public static function pesquisa($pesquisa)
    {
        $dao = new Movimentacao_estoqueDao;
        
        $tipos = (($pesquisa->he_entrada == 1)?MOVIMENTACAO_ENTRADA:'0'). ','.
                    (($pesquisa->he_saida == 1)?MOVIMENTACAO_SAIDA:'0'). ','.
                    (($pesquisa->he_reserva == 1)?MOVIMENTACAO_RESERVA:'0');
        unset($pesquisa->he_entrada);
        unset($pesquisa->he_saida);
        unset($pesquisa->he_reserva);
        $pesquisa->tipos = $tipos;
        return $dao->pesquisa($pesquisa);
    }

    public static function saidaEstoque($produtos_id, $quantidade, $reserva = 0)
    {
        
        $produto = Service::get('vw_produtos_estoque', 'produtos_id', $produtos_id);
        /*if ($produto->estoque_quantidade - $produto->quantidade_reservada < $quantidade) {
            Flash::setMsg("Não foi possivel dar saída do estoque do produto " . $produto->produtos_nome . " quantiade necessaria: " .
                $quantidade . " quantidade atual: " . ($produto->estoque_quantidade - $produto->quantidade_reservada), -1);
            throw new Exception("Estoque insuficiente para movimentar");
        } */      
        
        //salva estoque do produto
        $estoque_produto = new \stdClass();
        $estoque_produto->produtos_id = $produtos_id;
        $estoque_produto->estoque_quantidade = $produto->estoque_quantidade - $quantidade;
        ProdutosService::salvar($estoque_produto);
        
        //salva ficha de movimentação
        $movimentacao_estoque = new \stdClass();
        $movimentacao_estoque->movimentacao_estoque_id = 0;
        $movimentacao_estoque->produtos_id = $produtos_id;
        $movimentacao_estoque->quantidade = $quantidade;
        $movimentacao_estoque->tipo_movimentacao = MOVIMENTACAO_SAIDA;
        $movimentacao_estoque->descricao = "Saída de estoque";
        $movimentacao_estoque->usuarios_id = $_SESSION['id'];
        $movimentacao_estoque->reserva_id = $reserva;
        Movimentacao_estoqueService::salvar($movimentacao_estoque);
    }

    public static function entradaEstoque($produtos_id, $quantidade, $reserva = 0, $descricao = '')
    {        
        $produto = Service::get('vw_produtos_estoque', 'produtos_id', $produtos_id);     
        
        //salva estoque do produto
        $estoque_produto = new \stdClass();
        $estoque_produto->produtos_id = $produtos_id;
        $estoque_produto->estoque_quantidade = $produto->estoque_quantidade + $quantidade;
        ProdutosService::salvar($estoque_produto);
        
        //salva ficha de movimentação
        $movimentacao_estoque = new \stdClass();
        $movimentacao_estoque->movimentacao_estoque_id = 0;
        $movimentacao_estoque->produtos_id = $produtos_id;
        $movimentacao_estoque->quantidade = $quantidade;
        $movimentacao_estoque->tipo_movimentacao = MOVIMENTACAO_ENTRADA;
        $movimentacao_estoque->descricao = "Entrada de estoque. " . $descricao;
        $movimentacao_estoque->usuarios_id = $_SESSION['id'];
        $movimentacao_estoque->reserva_id = $reserva;
        Movimentacao_estoqueService::salvar($movimentacao_estoque);
    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}