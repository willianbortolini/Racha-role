<?php
namespace app\models\validacao;
use app\core\Validacao;

class TicketValidacao {
    public static function salvar($ticket) {
        $validacao = new Validacao();    
        $validacao->setData("user_id", $ticket->user_id, "User ID");
        $validacao->setData("subject", $ticket->subject, "Subject");
        $validacao->setData("imagem_perfil", $ticket->imagem_perfil, "Imagem de perfil");
        $validacao->setData("description", $ticket->description, "Description");
        $validacao->setData("CPF", $ticket->CPF, "CPF");
        $validacao->setData("status", $ticket->status, "Status");
        $validacao->setData("priority", $ticket->priority, "Priority");
    
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
