<?php
namespace app\models\validacao;
use app\core\Validacao;

class GruposValidacao {
    public static function salvar($grupos) {
        $validacao = new Validacao();    
        $validacao->setData("nome", $grupos->nome, "Nome");
    
        // Fazendo a validação
        $validacao->getData("nome")->isVazio();
   
        return $validacao;
    }
}
