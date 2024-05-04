<?php
namespace app\models\validacao;
use app\core\Validacao;

class FaturasValidacao {
    public static function salvar($faturas) {
        $validacao = new Validacao();    
        $validacao->setData("usuarios_id", $faturas->usuarios_id, "Usuários");
        $validacao->setData("data_emissao", $faturas->data_emissao, "Data emissão");
        $validacao->setData("data_vencimento", $faturas->data_vencimento, "Data vencimento");
        $validacao->setData("data_pagamento", $faturas->data_pagamento, "Data pagamento");
        $validacao->setData("data_cancelamento	", $faturas->data_cancelamento	, "Data cancelamento");
        $validacao->setData("valor_total", $faturas->valor_total, "Valor total");
        $validacao->setData("descricao", $faturas->descricao, "Descrição");
    
        // Fazendo a validação
        //$validacao->getData("Faturass_name")->isVazio();          
        
        return $validacao;
    }
}
