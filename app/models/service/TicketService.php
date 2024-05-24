<?php

namespace app\models\service;

use app\models\validacao\TicketValidacao;
use app\models\dao\TicketDao;
use app\util\UtilService;

class TicketService
{
    const TABELA = "tickets"; 
    const CAMPO = "tickets_id";     

    public static function salvar($Ticket)
    {
        $validacao = TicketValidacao::salvar($Ticket);
        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_imagem_perfil"]) && $_POST["remove_imagem_perfil"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Ticket->tickets_id);
                if (isset($existe_imagem->imagem_perfil) && $existe_imagem->imagem_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->imagem_perfil);
                }
                $Ticket->imagem_perfil = '';
            } else {
                if (isset($_FILES["imagem_perfil"]["name"]) && $_FILES["imagem_perfil"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Ticket->tickets_id);
                    if (isset($existe_imagem->imagem_perfil) && $existe_imagem->imagem_perfil != '') {
                      UtilService::deletarImagens($existe_imagem->imagem_perfil);
                    }
                    $Ticket->imagem_perfil = UtilService::uploadImagem("imagem_perfil", $config_upload);
                    if (!$Ticket->imagem_perfil) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($Ticket, self::CAMPO, $validacao->listaErros(), self::TABELA);

    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
}