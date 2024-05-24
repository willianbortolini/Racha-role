<?php
namespace app\models\validacao;
use app\core\Validacao;

class TicketValidacao {
    public static function salvar($ticket) {
        $validacao = new Validacao();    
        $validacao->setData("tickets_id", $ticket->tickets_id, "Ticket ID");
        $validacao->setData("user_id", $ticket->user_id, "User ID");
        $validacao->setData("subject", $ticket->subject, "Subject");
        $validacao->setData("description", $ticket->description, "Description");
        $validacao->setData("status", $ticket->status, "Status");
        $validacao->setData("priority", $ticket->priority, "Priority");
        $validacao->setData("created_at", $ticket->created_at, "Created At");
        $validacao->setData("updated_at", $ticket->updated_at, "Updated At");
    
        // Fazendo a validação
        //$validacao->getData("Tickets_name")->isVazio();          
        
        return $validacao;
    }
}
