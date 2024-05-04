<?php
namespace app\models\validacao;
use app\core\Validacao;

class ProdutosValidacao {
    public static function salvar($produtos) {
        $validacao = new Validacao();    
    
        // Fazendo a validação
        //$validacao->getData("Produtoss_name")->isVazio();          
        
        return $validacao;
    }
}
