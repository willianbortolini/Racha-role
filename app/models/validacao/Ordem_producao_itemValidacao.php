<?php
namespace app\models\validacao;
use app\core\Validacao;

class Ordem_producao_itemValidacao {
    public static function salvar($ordem_producao_item) {
        $validacao = new Validacao();    
        $validacao->setData("ordem_producao_id", $ordem_producao_item->ordem_producao_id, "Ordem produção");
        $validacao->setData("ambiente", $ordem_producao_item->ambiente, "Ambiente");
        $validacao->setData("modelo", $ordem_producao_item->modelo, "modelo");
        $validacao->setData("largura", $ordem_producao_item->largura, "Largura");
        $validacao->setData("altura", $ordem_producao_item->altura, "Altura");
    
        // Fazendo a validação
        //$validacao->getData("Ordem_producao_items_name")->isVazio();          
        
        return $validacao;
    }
}
