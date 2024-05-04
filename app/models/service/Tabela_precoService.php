<?php

namespace app\models\service;

use app\models\validacao\Tabela_precoValidacao;
use app\models\dao\Tabela_precoDao;
use app\util\UtilService;

class Tabela_precoService
{
    public static function salvar($tabela_preco, $campo, $tabela)
    {
        $validacao = Tabela_precoValidacao::salvar($tabela_preco);

        return Service::salvar($tabela_preco, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}