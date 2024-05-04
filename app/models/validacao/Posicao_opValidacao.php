<?php
namespace app\models\validacao;
use app\core\Validacao;

class Posicao_opValidacao {
    public static function salvar($posicao_op) {
        $validacao = new Validacao();    
        $validacao->setData("ativo", $posicao_op->ativo, "Posição ativa");
        $validacao->setData("descricao", $posicao_op->descricao, "Descrição");
        $validacao->setData("ordem", $posicao_op->ordem, "Ordem de exibição");
    
        // Fazendo a validação
        //$validacao->getData("Posicao_ops_name")->isVazio();          
        
        return $validacao;
    }
}
