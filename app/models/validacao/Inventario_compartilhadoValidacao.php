<?php
namespace app\models\validacao;
use app\core\Validacao;

class Inventario_compartilhadoValidacao {
    public static function salvar($inventario_compartilhado) {
        $validacao = new Validacao();    
        $validacao->setData("inventario_id", $inventario_compartilhado->inventario_id, "Inventario");
        $validacao->setData("usuarios_id", $inventario_compartilhado->usuarios_id, "usuario");
    
        // Fazendo a validação
        //$validacao->getData("Inventario_compartilhados_name")->isVazio();          
        
        return $validacao;
    }
}
