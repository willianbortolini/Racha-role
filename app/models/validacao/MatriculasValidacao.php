<?php
namespace app\models\validacao;
use app\core\Validacao;

class MatriculasValidacao {
    public static function salvar($matriculas) {
        $validacao = new Validacao();    
        $validacao->setData("usuarios_id", $matriculas->usuarios_id, "Usuario");
        $validacao->setData("cursos_id", $matriculas->cursos_id, "Curso");
        $validacao->setData("recebimentos_id", $matriculas->recebimentos_id, "Recebimento");
    
        // Fazendo a validação
        //$validacao->getData("Matriculass_name")->isVazio();          
        
        return $validacao;
    }
}
