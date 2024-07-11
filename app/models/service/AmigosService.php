<?php

namespace app\models\service;

use app\models\validacao\AmigosValidacao;
use app\models\dao\AmigosDao;
use app\util\UtilService;
use app\core\Flash;

class AmigosService
{
    const TABELA = "amigos"; 
    const CAMPO = "amigos_id";     

    public static function salvar($Amigos)
    {
        $validacao = AmigosValidacao::salvar($Amigos);
        
        $usuario = Service::get("users", "email", $Amigos->amigo);
     
        if($usuario->users_id == $Amigos->usuario_id){
            return 2;    
        }
        if (!isset($usuario->users_id)){          
            $usuario = Service::get("users", "telefone", $Amigos->amigo);
        } 
        
        if (!isset($usuario->users_id)){             
            Flash::setMsg('Usuário não encontrado',1);           
            return 0;
        }
        
        $dao = new AmigosDao();
        if ($dao->jaEamigo($usuario->users_id, $Amigos->usuario_id)){
            return 2;
        }

        unset($Amigos->amigo);        
        $Amigos->amigo_id = $usuario->users_id;
        return Service::salvar($Amigos, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function meusAmigos($users_id)
    {
        $dao = new AmigosDao();
        return $dao->meusAmigos($users_id);
    }

}