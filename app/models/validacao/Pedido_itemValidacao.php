<?php
namespace app\models\validacao;
use app\core\Validacao;

class Pedido_itemValidacao {
    public static function salvar($pedido_item) {
        $validacao = new Validacao();    
        $validacao->setData("pedidos_id", $pedido_item->pedidos_id, "Pedido");
        $validacao->setData("pedido_item_largura", $pedido_item->pedido_item_largura, "Largura");
        $validacao->setData("pedido_item_altura", $pedido_item->pedido_item_altura, "Altura");
        $validacao->setData("pedido_item_quantidade", $pedido_item->pedido_item_quantidade, "Quantidade");
    
        // Fazendo a validação
        //$validacao->getData("Pedido_items_name")->isVazio();          
        
        return $validacao;
    }
}
