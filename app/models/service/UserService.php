<?php

namespace app\models\service;

use app\models\validacao\UserValidacao;
use app\models\dao\UserDao;
use app\util\UtilService;
use app\models\service\Service;

class UserService
{
    public static function listaUsuarios($parametros)
    {
        $dao = new UserDao();
        return $dao->listaUsuarios($parametros);
    }

    public static function quantidadeClientes($valor_pesquisa)
    {
        $dao = new UserDao();
        return $dao->quantidadeClientes($valor_pesquisa);
    }
    public static function salvarImagemOrçamento($usuario, $campo, $tabela)
    {
        return Service::salvar($usuario, $campo, [], $tabela);
    }    
    public static function salvar($usuario, $campo, $tabela)
    {
        $validacao = UserValidacao::salvar($usuario);        

        if (isset($usuario->senha)) {

            $usuario->senha = password_hash($usuario->senha, PASSWORD_DEFAULT);
        }
        return Service::salvar($usuario, $campo, $validacao->listaErros(), $tabela);

    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }

    public static function recuperaSenha($usuario, $campo, $tabela)
    {
        $validacao = UserValidacao::recuperaSenha($usuario);
        unset($usuario->confirmacao);
        $usuario->senha = password_hash($usuario->senha, PASSWORD_DEFAULT);
        return Service::salvar($usuario, $campo, $validacao->listaErros(), $tabela);
    }
}