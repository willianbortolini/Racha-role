<?php
namespace app\models\validacao;
use app\core\Validacao;

class TicketsValidacao {
    public static function salvar($tickets) {
        $validacao = new Validacao();    
        $validacao->setData("user_id", $tickets->user_id, "User ID");
        $validacao->setData("subject", $tickets->subject, "Subject");
        $validacao->setData("imagem_perfil", $tickets->imagem_perfil, "Imagem de perfil");
        $validacao->setData("description", $tickets->description, "Description");
        $validacao->setData("CPF", $tickets->CPF, "CPF");
        $validacao->setData("status", $tickets->status, "Status");
        $validacao->setData("priority", $tickets->priority, "Priority");
    
        // Fazendo a validação
        $validacao->getData("user_id")->isVazio();
        $validacao->getData("subject")->isVazio();
        $validacao->getData("imagem_perfil")->isVazio();
        $validacao->getData("description")->isVazio();
        $validacao->getData("description")->isMinimo(5);
        $validacao->getData("CPF")->isVazio();
        $validacao->getData("CPF")->isMinimo(5);
        $validacao->getData("CPF")->isCPF();
        $validacao->getData("status")->isVazio();
        $validacao->getData("priority")->isVazio();
   
        return $validacao;
    }
}
