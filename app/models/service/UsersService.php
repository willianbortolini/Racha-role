<?php

namespace app\models\service;

use app\models\validacao\UsersValidacao;
use app\util\UtilService;
use app\models\dao\UsersDao;

class UsersService {

    public static function salvar($usuario, $campo, $tabela)
    {
        $validacao = UsersValidacao::salvar($usuario);

        unset($usuario->confirmacao); 
        if(isset($usuario->password)){
            $usuario->password = password_hash($usuario->password,PASSWORD_DEFAULT);
        }
        return Service::salvar($usuario, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }

    public static function recuperaSenha($usuario, $campo, $tabela) {        
        $validacao = UsersValidacao::recuperapassword($usuario);         
        unset($usuario->confirmacao); 
        if(isset($usuario->senha)){
            $usuario->senha = password_hash($usuario->senha,PASSWORD_DEFAULT);
        }
         return Service::salvar($usuario, $campo, $validacao->listaErros(), $tabela);
    }

    

}
