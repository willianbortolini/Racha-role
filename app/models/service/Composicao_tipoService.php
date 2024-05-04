<?php

namespace app\models\service;

use app\models\validacao\Composicao_tipoValidacao;
use app\models\dao\Composicao_tipoDao;
use app\util\UtilService;

class Composicao_tipoService
{
    public static function salvar($composicao_tipo, $campo, $tabela)
    {
        $validacao = Composicao_tipoValidacao::salvar($composicao_tipo);

        return Service::salvar($composicao_tipo, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}