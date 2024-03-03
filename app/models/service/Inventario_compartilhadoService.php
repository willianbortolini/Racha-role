<?php

namespace app\models\service;

use app\models\validacao\Inventario_compartilhadoValidacao;
use app\models\dao\Inventario_compartilhadoDao;
use app\util\UtilService;

class Inventario_compartilhadoService
{

    private static $tabela = "inventario_compartilhado";
    private static $campo = "inventario_compartilhado_id";
    public static function salvar($inventario_compartilhado)
    {
        $validacao = Inventario_compartilhadoValidacao::salvar($inventario_compartilhado);
        return Service::salvar($inventario_compartilhado, self::$campo, $validacao->listaErros(), self::$tabela);
    }  

    public static function inventarioUsuario($inventarios_id, $usuarios_id)
    {
        $dao = new Inventario_compartilhadoDao();
        return $dao->inventarioUsuario($inventarios_id, $usuarios_id);
    } 

    public static function excluir($id)
    {
        Service::excluir(self::$tabela, self::$campo, $id);
    }
}