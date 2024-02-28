<?php

namespace app\models\service;

use app\models\validacao\MatriculasValidacao;
use app\models\dao\MatriculasDao;
use app\util\UtilService;

class MatriculasService
{
    public static function salvar($matriculas, $campo, $tabela)
    {
        $validacao = MatriculasValidacao::salvar($matriculas);

        return Service::salvar($matriculas, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}