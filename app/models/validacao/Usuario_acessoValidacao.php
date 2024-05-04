<?php
namespace app\models\validacao;
use app\core\Validacao;

class Usuario_acessoValidacao {
    public static function salvar($usuario_acesso) {
        $validacao = new Validacao();    
        $validacao->setData("usuarios_id", $usuario_acesso->usuarios_id, "usuario");
        $validacao->setData("acesso", $usuario_acesso->acesso, "acesso");
    
        // Fazendo a validação
        //$validacao->getData("Usuario_acessos_name")->isVazio();          
        
        return $validacao;
    }
}
