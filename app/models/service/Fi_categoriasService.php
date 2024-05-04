<?php

namespace app\models\service;

use app\models\validacao\Fi_categoriasValidacao;
use app\models\dao\Fi_categoriasDao;
use app\util\UtilService;

class Fi_categoriasService
{
    public static function salvar($fi_categorias, $campo, $tabela)
    {
        $validacao = Fi_categoriasValidacao::salvar($fi_categorias);

        return Service::salvar($fi_categorias, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}