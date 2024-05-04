<?php
namespace app\models\validacao;
use app\core\Validacao;

class Composicao_tipoValidacao {
    public static function salvar($composicao_tipo) {
        $validacao = new Validacao();    
        $validacao->setData("composicao_tipo_nome", $composicao_tipo->composicao_tipo_nome, "Nome");
    
        // Fazendo a validação
        //$validacao->getData("Composicao_tipos_name")->isVazio();          
        
        return $validacao;
    }
}
