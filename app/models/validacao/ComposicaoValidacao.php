<?php
namespace app\models\validacao;
use app\core\Validacao;

class ComposicaoValidacao {
    public static function salvar($composicao) {
        $validacao = new Validacao();    
        $validacao->setData("composicao_nome", $composicao->composicao_nome, "Nome");
        $validacao->setData("composicao_tipo_id", $composicao->composicao_tipo_id, "Tipo");
        $validacao->setData("composicao_pai_id", $composicao->composicao_pai_id, "Composição pai");
        $validacao->setData("produtos_id", $composicao->produtos_id, "Produto");    
        
        return $validacao;
    }
}
