<?php
namespace app\models\validacao;
use app\core\Validacao;

class RecebimentosValidacao {
    public static function salvar($recebimentos) {
        $validacao = new Validacao();    
        $validacao->setData("usuarios_id", $recebimentos->usuarios_id, "Usuario");
        $validacao->setData("cursos_id", $recebimentos->cursos_id, "Curso");
        $validacao->setData("valor", $recebimentos->valor, "Valor");
        $validacao->setData("metodo", $recebimentos->metodo, "Método");
        $validacao->setData("id_mercado_pago", $recebimentos->id_mercado_pago, "Id mercado pago");
        $validacao->setData("email", $recebimentos->email, "Email");
        $validacao->setData("recebimento_data", $recebimentos->recebimento_data, "Data do recebimento");
        $validacao->setData("recebimento_status", $recebimentos->recebimento_status, "Status do recebimento");
        $validacao->setData("recebimento_data_liberacao", $recebimentos->recebimento_data_liberacao, "Data da liberação do recebimento");
    
        // Fazendo a validação
        //$validacao->getData("Recebimentoss_name")->isVazio();          
        
        return $validacao;
    }
}
