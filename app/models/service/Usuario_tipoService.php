<?php

namespace app\models\service;

use app\models\validacao\Usuario_tipoValidacao;
use app\models\dao\Usuario_tipoDao;
use app\util\UtilService;

class Usuario_tipoService
{
    private static $tabela = "usuario_tipo";
    private static $campo = "usuario_tipo_id";
    public static function salvar($usuario_tipo)
    {
        $validacao = Usuario_tipoValidacao::salvar($usuario_tipo);

        return Service::salvar($usuario_tipo, self::$campo, $validacao->listaErros(), self::$tabela);

    }

    public static function usuariosComTipo($usuario_tipo)
    {
        $dao = new Usuario_tipoDao;
        return $dao->usuariosComTipo($usuario_tipo);
    }

    public static function tiposUsuario($usuarios_id)
    {
        $dao = new Usuario_tipoDao;
        return $dao->tiposUsuario($usuarios_id);
    }


    public static function validaUsuarioTemTipo($usuario_tipo, $usuarios_id)
    {
        $tipos_usuario = self::tiposUsuario($usuarios_id);
        return in_array($usuario_tipo, $tipos_usuario);
    }

    public static function excluir($id)
    {
        Service::excluir(self::$tabela, self::$campo, $id);
    }


}