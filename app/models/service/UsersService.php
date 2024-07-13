<?php

namespace app\models\service;

use app\models\validacao\UsersValidacao;
use app\models\dao\UsersDao;
use app\util\UtilService;

class UsersService
{
    const TABELA = "users"; 
    const CAMPO = "users_id";     

    public static function salvar($Users)
    {
        if($Users->users_id > 0){
            $validacao = UsersValidacao::editar($Users);
        }else{
            
            $validacao = UsersValidacao::salvar($Users);
        }     
        global $config_upload;        
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_foto_perfil"]) && $_POST["remove_foto_perfil"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->foto_perfil);
                }
                $Users->foto_perfil = '';
            } else {
                
                if (isset($_FILES["foto_perfil"]["name"]) && $_FILES["foto_perfil"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                    if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                      UtilService::deletarImagens($existe_imagem->foto_perfil);
                    }
                    $Users->foto_perfil = UtilService::uploadImagem("foto_perfil", $config_upload);
                    if (!$Users->foto_perfil) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($Users, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function criar($Users)
    {
        $validacao = UsersValidacao::salvar($Users);
        unset($Users->confirmacao); 
        if(isset($Users->password)){
            $Users->password = password_hash($Users->password,PASSWORD_DEFAULT);
            $Users->users_uid = UtilService::generateUUID();
        }

        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_foto_perfil"]) && $_POST["remove_foto_perfil"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->foto_perfil);
                }
                $Users->foto_perfil = '';
            } else {
                if (isset($_FILES["foto_perfil"]["name"]) && $_FILES["foto_perfil"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                    if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                      UtilService::deletarImagens($existe_imagem->foto_perfil);
                    }
                    $Users->foto_perfil = UtilService::uploadImagem("foto_perfil", $config_upload);
                    if (!$Users->foto_perfil) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($Users, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function ativo($Users)
    {     
        return Service::salvar($Users, self::CAMPO, [], self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function recuperaSenha($usuario, $campo, $tabela) {        
        $validacao = UsersValidacao::recuperapassword($usuario);         
        unset($usuario->confirmacao); 
        if(isset($usuario->password)){
            $usuario->password = password_hash($usuario->password,PASSWORD_DEFAULT);
        }
         return Service::salvar($usuario, $campo, $validacao->listaErros(), $tabela);
    }

    
}