<?php
namespace app\models\validacao;
use app\core\Validacao;

class Usuarios_gruposValidacao {
    public static function salvar($usuarios_grupos) {
        $validacao = new Validacao();    
        $validacao->setData("users_id", $usuarios_grupos->users_id, "ID do usuário");
        $validacao->setData("grupos_id", $usuarios_grupos->grupos_id, "ID do Grupo");
    
        // Fazendo a validação
        $validacao->getData("users_id")->isVazio();
        $validacao->getData("grupos_id")->isVazio();
   
        return $validacao;
    }
}
