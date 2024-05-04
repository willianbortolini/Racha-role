<?php
namespace app\models\validacao;
use app\core\Validacao;

class Fi_contaValidacao {
    public static function salvar($fi_conta) {
        $validacao = new Validacao();    
        $validacao->setData("fi_conta_nome", $fi_conta->fi_conta_nome, "Nome");
        $validacao->setData("usuarios_id", $fi_conta->usuarios_id, "Usuário");
    
        // Fazendo a validação
        //$validacao->getData("Fi_contas_name")->isVazio();          
        
        return $validacao;
    }
}
