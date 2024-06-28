<?php
namespace app\models\validacao;
use app\core\Validacao;

class Participantes_despesasValidacao {
    public static function salvar($participantes_despesas) {
        $validacao = new Validacao();    
        $validacao->setData("despesas_id", $participantes_despesas->despesas_id, "ID da Despesa");
        $validacao->setData("users_id", $participantes_despesas->users_id, "ID do Usuário");
        $validacao->setData("devendo_para", $participantes_despesas->devendo_para, "ID do pagador");
        $validacao->setData("valor", $participantes_despesas->valor, "Valor");
        $validacao->setData("valor_pago", $participantes_despesas->valor_pago, "Valor pago");
    
        // Fazendo a validação
        $validacao->getData("despesas_id")->isVazio();
        $validacao->getData("users_id")->isVazio();
        $validacao->getData("devendo_para")->isVazio();
        $validacao->getData("valor")->isVazio();
   
        return $validacao;
    }
}
