<?php
namespace app\models\validacao;
use app\core\Validacao;

class DespesasValidacao {
    public static function salvar($despesas) {
        $validacao = new Validacao();    
        $validacao->setData("descricao", $despesas->descricao, "Descrição");
        $validacao->setData("valor", $despesas->valor, "Valor");
        $validacao->setData("data", $despesas->data, "Data");
        $validacao->setData("users_id", $despesas->users_id, "ID do Usuário");
        $validacao->setData("grupos_id", $despesas->grupos_id, "ID do Grupo");
    
        // Fazendo a validação
        $validacao->getData("descricao")->isVazio();
        $validacao->getData("valor")->isVazio();
        $validacao->getData("data")->isVazio();
        $validacao->getData("users_id")->isVazio();
        $validacao->getData("grupos_id")->isVazio();
   
        return $validacao;
    }
}
