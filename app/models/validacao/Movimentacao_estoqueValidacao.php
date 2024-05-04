<?php
namespace app\models\validacao;
use app\core\Validacao;

class Movimentacao_estoqueValidacao {
    public static function salvar($movimentacao_estoque) {
        $validacao = new Validacao();    
        $validacao->setData("produtos_id", $movimentacao_estoque->produtos_id, "Produto");
        $validacao->setData("quantidade", $movimentacao_estoque->quantidade, "Quantidade");
        $validacao->setData("tipo_movimentacao", $movimentacao_estoque->tipo_movimentacao, "Tipo de movimentação");
        $validacao->setData("descricao", $movimentacao_estoque->descricao, "Descrição");
        $validacao->setData("usuarios_id", $movimentacao_estoque->usuarios_id, "Usuário");
        $validacao->setData("reserva_id", $movimentacao_estoque->reserva_id, "reserva");
    
        // Fazendo a validação
        //$validacao->getData("Movimentacao_estoques_name")->isVazio();          
        
        return $validacao;
    }
}
