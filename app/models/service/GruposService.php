<?php

namespace app\models\service;

use app\models\validacao\GruposValidacao;
use app\models\dao\GruposDao;
use app\models\service\Usuarios_gruposService;
use app\models\service\ImagemService;


class GruposService
{
    
    const TABELA = "grupos"; 
    const CAMPO = "grupos_id";     

    public static function salvar($Grupos)
    {
        $validacao = GruposValidacao::salvar($Grupos);
        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_foto"]) && $_POST["remove_foto"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Grupos->grupos_id);
                if (isset($existe_imagem->foto) && $existe_imagem->foto != '') {
                    ImagemService::deletarImagens($existe_imagem->foto);
                }
                $Grupos->foto = '';
            } else {
                if (isset($_FILES["foto"]["name"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Grupos->grupos_id);
                    if (isset($existe_imagem->foto) && $existe_imagem->foto != '') {
                        ImagemService::deletarImagens($existe_imagem->foto);
                    }
                    $Grupos->foto = ImagemService::uploadImagem150e500("foto", $config_upload);
                    if (!$Grupos->foto) {
                        return false;
                    }
                }
            }
        }     
        $grupos_id = Service::salvar($Grupos, self::CAMPO, $validacao->listaErros(), self::TABELA);    
        
        if ($grupos_id == 1){
            return 1;                      
        } else if($grupos_id > 1){
            $usuarios_grupos = new \stdClass();
            $usuarios_grupos->usuarios_grupos_id = 0;     
            $usuarios_grupos->grupos_id = $grupos_id;              
            if(Usuarios_gruposService::salvar($usuarios_grupos, [$_SESSION['id']]) == 1){
                return $grupos_id;
            }else{
                return 0;
            } 
        }else{
            return 0;
        }
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function gruposDoUsuario($usuario_id)
    {
        $dao = new GruposDao();
        return $dao->gruposDoUsuario($usuario_id);
    }

    public static function gruposQuitados($users_id)
    {
        $dao = new GruposDao();
        return $dao->gruposQuitados($users_id);
    }
    





}