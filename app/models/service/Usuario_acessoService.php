<?php

namespace app\models\service;

use app\models\validacao\Usuario_acessoValidacao;
use app\models\dao\Usuario_acessoDao;
use app\util\UtilService;

class Usuario_acessoService
{
    public static function deleteUsuarioAcesso($usuarios_id, $acesso)
    {
        $dao = new Usuario_acessoDao;
        return $dao->deleteUsuarioAcesso($usuarios_id, $acesso);
    }
    public static function acessosDoUsuario($usuarios_id)
    {
        $dao = new Usuario_acessoDao;
        $acessosSalvos = $dao->acessosDoUsuario($usuarios_id);
        $valores_acesso = [];
        foreach ($acessosSalvos as $item) {
            $valores_acesso[] = $item->acesso;
        }
        return $valores_acesso;
    }
    public static function salvar($usuario_acesso, $campo, $tabela)
    {
        $validacao = Usuario_acessoValidacao::salvar($usuario_acesso);

        return Service::salvar($usuario_acesso, $campo, $validacao->listaErros(), $tabela);

    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}