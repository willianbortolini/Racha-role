<?php

namespace app\models\service;

use app\models\validacao\TicketsValidacao;
use app\models\dao\TicketsDao;
use app\util\UtilService;

class TicketsService
{
    const TABELA = "tickets"; 
    const CAMPO = "tickets_id";     

    public static function salvar($Tickets)
    {
        $validacao = TicketsValidacao::salvar($Tickets);
        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_imagem_perfil"]) && $_POST["remove_imagem_perfil"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Tickets->tickets_id);
                if (isset($existe_imagem->imagem_perfil) && $existe_imagem->imagem_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->imagem_perfil);
                }
                $Tickets->imagem_perfil = '';
            } else {
                if (isset($_FILES["imagem_perfil"]["name"]) && $_FILES["imagem_perfil"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Tickets->tickets_id);
                    if (isset($existe_imagem->imagem_perfil) && $existe_imagem->imagem_perfil != '') {
                      UtilService::deletarImagens($existe_imagem->imagem_perfil);
                    }
                    $Tickets->imagem_perfil = UtilService::uploadImagem("imagem_perfil", $config_upload);
                    if (!$Tickets->imagem_perfil) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($Tickets, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new TicketsDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new TicketsDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }
}