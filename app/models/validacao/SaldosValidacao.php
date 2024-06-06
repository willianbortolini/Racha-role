<?php
namespace app\models\validacao;
use app\core\Validacao;

class SaldosValidacao {
    public static function salvar($saldos) {
        $validacao = new Validacao();    
        $validacao->setData("devedor_id", $saldos->devedor_id, "ID do Devedor");
        $validacao->setData("credor_id", $saldos->credor_id, "ID do Credor");
        $validacao->setData("valor", $saldos->valor, "Valor");
    
        // Fazendo a validação
        $validacao->getData("devedor_id")->isVazio();
        $validacao->getData("credor_id")->isVazio();
        $validacao->getData("valor")->isVazio();
   
        return $validacao;
    }
}
