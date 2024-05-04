<?php
namespace app\models\validacao;
use app\core\Validacao;

class Fi_transacoesValidacao {
    public static function salvar($fi_transacoes) {
        $validacao = new Validacao();    
        $validacao->setData("tipo", $fi_transacoes->tipo, "Tipo");
        $validacao->setData("usuarios_id", $fi_transacoes->usuarios_id, "Usuário");
        $validacao->setData("valor", $fi_transacoes->valor, "Valor");
        $validacao->setData("data", $fi_transacoes->data, "data");
        $validacao->setData("data_pagamento", $fi_transacoes->data_pagamento, "data pagamento");
        $validacao->setData("descricao", $fi_transacoes->descricao, "Descrição");
        $validacao->setData("fi_categorias_id", $fi_transacoes->fi_categorias_id, "Categoria");
        $validacao->setData("numero_parcelas", $fi_transacoes->numero_parcelas, "numero parcelas");
        $validacao->setData("parcela_atual", $fi_transacoes->parcela_atual, "parcela atual");
        $validacao->setData("fi_conta_id", $fi_transacoes->fi_conta_id, "Conta");
        $validacao->setData("fi_meio_id", $fi_transacoes->fi_meio_id, "Meio");
    
        // Fazendo a validação
        //$validacao->getData("Fi_transacoess_name")->isVazio();          
        
        return $validacao;
    }
}
