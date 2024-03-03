<?php

namespace app\models\service;

use app\models\validacao\InventarioValidacao;
use app\models\dao\InventarioDao;
use app\util\UtilService;

class InventarioService
{
    public static function salvar($inventario, $campo, $tabela)
    {
        $validacao = InventarioValidacao::salvar($inventario);

        return Service::salvar($inventario, $campo, $validacao->listaErros(), $tabela);

    } 
    
    public static function  inventariosCompartilhados($usuarios_id)
    {
        $dao = new InventarioDao();
        return $dao->inventariosCompartilhados($usuarios_id); 

    } 
   

    public static function generateUUIDv4() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}