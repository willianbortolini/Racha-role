<?php
namespace app\models\validacao;
use app\core\Validacao;

class ReservaValidacao {
    public static function salvar($reserva) {
        $validacao = new Validacao();    
        $validacao->setData("produtos_id", $reserva->produtos_id, "Produto");
        $validacao->setData("quantidade", $reserva->quantidade, "Quantidade");
        $validacao->setData("tipo", $reserva->tipo, "Tipo de Reserva");
        $validacao->setData("reservado", $reserva->reservado, "Reservado");
        $validacao->setData("documento", $reserva->documento, "Documento");
        $validacao->setData("descricao", $reserva->descricao, "Descrição");
    
        // Fazendo a validação
        //$validacao->getData("Reservas_name")->isVazio();          
        
        return $validacao;
    }
}
