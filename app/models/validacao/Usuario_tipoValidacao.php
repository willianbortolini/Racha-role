<?php
namespace app\models\validacao;
use app\core\Validacao;

class Usuario_tipoValidacao {
    public static function salvar($usuario_tipo) {
        $validacao = new Validacao();    
        $validacao->setData("usuarios_id", $usuario_tipo->usuarios_id, "Usuário");
        $validacao->setData("usuario_tipo", $usuario_tipo->usuario_tipo, "tipo usuario");
    
        // Fazendo a validação
        //$validacao->getData("Usuario_tipos_name")->isVazio();          
        
        return $validacao;
    }
}
