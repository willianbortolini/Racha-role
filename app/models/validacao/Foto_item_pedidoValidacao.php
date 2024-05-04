<?php
namespace app\models\validacao;
use app\core\Validacao;

class Foto_item_pedidoValidacao {
    public static function salvar($foto_item_pedido) {
        $validacao = new Validacao();    
        $validacao->setData("pedido_item_id", $foto_item_pedido->pedido_item_id, "id do produto");
    
        // Fazendo a validação
        //$validacao->getData("Foto_item_pedidos_name")->isVazio();          
        
        return $validacao;
    }
}
