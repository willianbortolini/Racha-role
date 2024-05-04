<?php
namespace app\models\validacao;
use app\core\Validacao;

class StatusPedidoValidacao {
    public static function salvar($statusPedido) {
        $validacao = new Validacao();    
        $validacao->setData("statusPedido_nome", $statusPedido->statusPedido_nome, "status");
    
        // Fazendo a validação
        //$validacao->getData("StatusPedidos_name")->isVazio();          
        
        return $validacao;
    }
}
