<?php

namespace app\models\service;

use app\models\validacao\Fi_contaValidacao;
use app\models\dao\Fi_contaDao;
use app\util\UtilService;

class Fi_contaService
{
    public static function salvar($fi_conta, $campo, $tabela)
    {
        $validacao = Fi_contaValidacao::salvar($fi_conta);

        return Service::salvar($fi_conta, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}