<?php
namespace app\models\validacao;
use app\core\Validacao;

class InventarioValidacao {
    public static function salvar($inventario) {
        $validacao = new Validacao();    
        $validacao->setData("nome", $inventario->nome, "Nome");
        $validacao->setData("localizacao", $inventario->localizacao, "Localizacao");
        $validacao->setData("responsavel", $inventario->responsavel, "Responsavel");
        $validacao->setData("usuarios_id", $inventario->usuarios_id, "Usuario");
    
        // Fazendo a validação
        //$validacao->getData("Inventarios_name")->isVazio();          
        
        return $validacao;
    }
}
