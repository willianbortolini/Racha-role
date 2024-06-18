<?php
namespace app\models\validacao;
use app\core\Validacao;

class ConvitesValidacao {
    public static function salvar($convites) {
        $validacao = new Validacao();    
        $validacao->setData("usuario_id", $convites->usuario_id, "ID do Usuário");
    
        // Fazendo a validação
        $validacao->getData("usuario_id")->isVazio();
   
        return $validacao;
    }
}
