<?php
namespace app\models\validacao;
use app\core\Validacao;

class Op_item_posicaoValidacao {
    public static function salvar($op_item_posicao) {
        $validacao = new Validacao();    
        $validacao->setData("posicao_op_id", $op_item_posicao->posicao_op_id, "posicao op id");
        $validacao->setData("ordem_producao_item_id", $op_item_posicao->ordem_producao_item_id, "ordem_producao item id");
        $validacao->setData("conteudo_op_item", $op_item_posicao->conteudo_op_item, "conteudo op item");
    
        // Fazendo a validação
        //$validacao->getData("Op_item_posicaos_name")->isVazio();          
        
        return $validacao;
    }
}
