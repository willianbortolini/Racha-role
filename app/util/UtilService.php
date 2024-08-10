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
    
}