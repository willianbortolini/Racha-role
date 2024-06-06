<?php
namespace app\models\validacao;
use app\core\Validacao;

class Participantes_despesasValidacao {
    public static function salvar($participantes_despesas) {
        $validacao = new Validacao();    
        $validacao->setData("despesas_id", $participantes_despesas->despesas_id, "ID da Despesa");
        $validacao->setData("users_id", $participantes_despesas->users_id, "ID do Usuário");
        $validacao->setData("valor", $participantes_despesas->valor, "Valor");
    
        // Fazendo a validação
        $validacao->getData("despesas_id")->isVazio();
        $validacao->getData("users_id")->isVazio();
        $validacao->getData("valor")->isVazio();
   
        return $validacao;
    }
}
