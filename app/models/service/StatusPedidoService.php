<?php

namespace app\models\service;

use app\models\validacao\StatusPedidoValidacao;
use app\models\dao\StatusPedidoDao;
use app\util\UtilService;

class StatusPedidoService
{
    public static function salvar($statusPedido, $campo, $tabela)
    {
        $validacao = StatusPedidoValidacao::salvar($statusPedido);

        return Service::salvar($statusPedido, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}