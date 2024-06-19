<?php

namespace app\models\service;

use app\models\validacao\GruposValidacao;
use app\models\dao\GruposDao;
use app\util\UtilService;

class GruposService extends Service
{   

    public function __construct()
    {
        static::$tabela = "grupos";
    }

    
    /*public static function salvar($Grupos)
    {
        $validacao = GruposValidacao::salvar($Grupos);
        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_foto"]) && $_POST["remove_foto"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Grupos->grupos_id);
                if (isset($existe_imagem->foto) && $existe_imagem->foto != '') {
                    UtilService::deletarImagens($existe_imagem->foto);
                }
                $Grupos->foto = '';
            } else {
                if (isset($_FILES["foto"]["name"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Grupos->grupos_id);
                    if (isset($existe_imagem->foto) && $existe_imagem->foto != '') {
                      UtilService::deletarImagens($existe_imagem->foto);
                    }
                    $Grupos->foto = UtilService::uploadImagem("foto", $config_upload);
                    if (!$Grupos->foto) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($Grupos, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function gruposDoUsuario()
    {
        $dao = new GruposDao();
        return $dao->gruposDoUsuario($_SESSION['id']);
    }
    

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }
    public static function lista($parametros)
    {
        $dao = new GruposDao();
        return $dao->lista($parametros);
    }

    public static function quantidadeDeLinhas($valor_pesquisa)
    {
        $dao = new GruposDao();
        return $dao->quantidadeDeLinhas($valor_pesquisa);
    }*/
}