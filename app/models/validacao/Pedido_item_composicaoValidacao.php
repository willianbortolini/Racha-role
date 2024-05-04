<?php
namespace app\models\validacao;
use app\core\Validacao;

class Pedido_item_composicaoValidacao {
    public static function salvar($pedido_item_composicao) {
        $validacao = new Validacao();    
        $validacao->setData("pedido_item_id", $pedido_item_composicao->pedido_item_id, "pedido_item_id");
        $validacao->setData("composicao_id", $pedido_item_composicao->composicao_id, "composicao_id");
        $validacao->setData("pedido_item_composicao_valor", $pedido_item_composicao->pedido_item_composicao_valor, "valor no select");
        $validacao->setData("pedido_item_composicao_valorMonetario ", $pedido_item_composicao->pedido_item_composicao_valorMonetario , "valor financeiro");
    
        // Fazendo a validação
        //$validacao->getData("Pedido_item_composicaos_name")->isVazio();          
        
        return $validacao;
    }
}
