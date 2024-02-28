<?php
namespace app\models\validacao;
use app\core\Validacao;

class Inventario_itemValidacao {
    public static function salvar($inventario_item) {
        $validacao = new Validacao();    
        $validacao->setData("inventario_id", $inventario_item->inventario_id, "Inventario");
        $validacao->setData("ean13", $inventario_item->ean13, "EAN-13");
    
        // Fazendo a validação
        $validacao->getData("ean13")->isVazio();          
        
        return $validacao;
    }
}
