<?php
namespace app\models\validacao;
use app\core\Validacao;

class Tabela_preco_itemValidacao {
    public static function salvar($tabela_preco_item) {
        $validacao = new Validacao();    
        $validacao->setData("tabela_preco_id", $tabela_preco_item->tabela_preco_id, "Tabela Preço");
        $validacao->setData("largura", $tabela_preco_item->largura, "Largura");
        $validacao->setData("altura", $tabela_preco_item->altura, "Altura");
        $validacao->setData("valor", $tabela_preco_item->valor, "Valor");
    
        // Fazendo a validação
        //$validacao->getData("Tabela_preco_items_name")->isVazio();          
        
        return $validacao;
    }
}
