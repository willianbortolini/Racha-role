<?php
namespace app\models\validacao;
use app\core\Validacao;

class AmigosValidacao {
    public static function salvar($amigos) {
        $validacao = new Validacao();    
        $validacao->setData("usuario_id", $amigos->usuario_id, "ID do Usuário");
        $validacao->setData("amigo_id", $amigos->amigo_id, "ID do Amigo");
        $validacao->setData("status", $amigos->status, "Status");
    
        // Fazendo a validação
        $validacao->getData("usuario_id")->isVazio();
        $validacao->getData("amigo_id")->isVazio();
        $validacao->getData("status")->isVazio();
   
        return $validacao;
    }
}
