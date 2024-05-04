<?php
namespace app\models\validacao;
use app\core\Validacao;

class Tabela_precoValidacao {
    public static function salvar($tabela_preco) {
        $validacao = new Validacao();    
        $validacao->setData("tabela_preco_nome", $tabela_preco->tabela_preco_nome, "Nome");
        // Fazendo a validação
        //$validacao->getData("Tabela_precos_name")->isVazio();          
        
        return $validacao;
    }
}
