<?php
namespace app\util;

use app\core\Flash;
use app\models\service\Service;
use Exception;

class UtilService
{
    public static function upload($arquivo, $config)
    {
        
        $subir = upload($arquivo, $config);
        if ($subir->erro == 0) {
            Flash::limpaForm();
            return $subir->nome;
        } else {
            Flash::limpaMsg();
            Flash::setMsg("Erro: " . $subir->msg, -1);
            return false;
        }
    }

    public static function uploadImagem($arquivo, $config)
    {
        
        $subir = uploadImagem2($arquivo, $config);

        if ($subir->erro == 0) {
            Flash::limpaForm();
            return $subir->nome;
        } else {
            Flash::limpaMsg();
            Flash::setMsg("Erro: " . $subir->msg, -1);
            return false;
        }
    }

    public static function uploadImagemGrande($arquivo, $config)
    {
        
        $subir = uploadImagemGrande($arquivo, $config);

        if ($subir->erro == 0) {
            Flash::limpaForm();
            return $subir->nome;
        } else {
            Flash::limpaMsg();
            Flash::setMsg("Erro: " . $subir->msg, -1);
            return false;
        }
    }

    public static function deletarImagens($nomeImagem)
    {
        $descer = deletarImagens($nomeImagem);

        if ($descer->erro == 0) {
            Flash::limpaForm();
            return $descer->nome;
        } else {
            Flash::limpaMsg();
            Flash::setMsg("Erro: " . $descer->msg, -1);
            return false;
        }
    }
}