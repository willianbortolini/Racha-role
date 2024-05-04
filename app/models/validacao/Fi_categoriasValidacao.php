<?php
namespace app\models\validacao;
use app\core\Validacao;

class Fi_categoriasValidacao {
    public static function salvar($fi_categorias) {
        $validacao = new Validacao();    
        $validacao->setData("fi_categorias_nome", $fi_categorias->fi_categorias_nome, "Nome");
        $validacao->setData("usuarios_id", $fi_categorias->usuarios_id, "Usuário");
    
        // Fazendo a validação
        //$validacao->getData("Fi_categoriass_name")->isVazio();          
        
        return $validacao;
    }
}
