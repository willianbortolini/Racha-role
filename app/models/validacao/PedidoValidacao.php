<?php
namespace app\models\validacao;
use app\core\Validacao;

class PedidoValidacao {
    public static function salvar($pedido) {
        $validacao = new Validacao(); 
    
        // Fazendo a validação
        //$validacao->getData("Pedidos_name")->isVazio();          
        
        return $validacao;
    }
}
