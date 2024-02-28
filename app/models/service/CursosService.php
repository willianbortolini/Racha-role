<?php

namespace app\models\service;

use app\models\validacao\CursosValidacao;
use app\models\dao\CursosDao;
use app\util\UtilService;

class CursosService
{
    public static function salvar($cursos, $campo, $tabela)
    {
        $validacao = CursosValidacao::salvar($cursos);
global $config_upload;
if ($validacao->qtdeErro() <= 0) {
        if (isset($_POST["remove_url_imagem"]) && $_POST["remove_url_imagem"] === "1") {
            $existe_imagem = service::get($tabela, $campo, $cursos->Cursos_id);
            if (isset($existe_imagem->url_imagem) && $existe_imagem->url_imagem != '') {
                UtilService::deletarImagens($existe_imagem->url_imagem);
            }
            $cursos->url_imagem = '';
        } else {
            if (isset($_FILES["url_imagem"]["name"]) && $_FILES["url_imagem"]["error"] === UPLOAD_ERR_OK) {
                $existe_imagem = service::get($tabela, $campo, $cursos->Cursos_id);
                if (isset($existe_imagem->url_imagem) && $existe_imagem->url_imagem != '') {
                    UtilService::deletarImagens($existe_imagem->url_imagem);
                }
                $cursos->url_imagem = UtilService::uploadImagem("url_imagem", $config_upload);
                if (!$cursos->url_imagem) {
                    return false;
                }
            }
        }
}

        return Service::salvar($cursos, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}