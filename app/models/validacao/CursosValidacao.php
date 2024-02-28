<?php
namespace app\models\validacao;
use app\core\Validacao;

class CursosValidacao {
    public static function salvar($cursos) {
        $validacao = new Validacao();    
        $validacao->setData("nome", $cursos->nome, "Nome do curso");
        $validacao->setData("area", $cursos->area, "Area");
        $validacao->setData("descricao", $cursos->descricao, "Descrição");
        $validacao->setData("desconto", $cursos->desconto, "Desconto");
        $validacao->setData("preco_original", $cursos->preco_original, "Preço original");
        $validacao->setData("preco", $cursos->preco, "Preço");
        $validacao->setData("professor_id", $cursos->professor_id, "professor");
    
        // Fazendo a validação
        //$validacao->getData("Cursoss_name")->isVazio();          
        
        return $validacao;
    }
}
