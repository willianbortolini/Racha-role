<?php
namespace app\models\validacao;
use app\core\Validacao;

class Ordem_producaoValidacao {
    public static function salvar($ordem_producao) {
        $validacao = new Validacao();    

    
        // Fazendo a validação
        //$validacao->getData("Ordem_producaos_name")->isVazio();          
        
        return $validacao;
    }
}
