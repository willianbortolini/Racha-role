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

    public static function getUsuario()
    {
        $usuario = null;
        if (isset($_SESSION['id'])) {
            $usuario = $_SESSION['id'];
        }
        return $usuario;
    }

    public static function validaUsuario()
    {
        $usuario = null;
        if (isset($_SESSION['id'])) {
            $usuario = $_SESSION['id'];
        } else {
            header('Location:' . URL_BASE . "login");
            exit;
        }
        return $usuario;
    }

    public static function validaNivel($nivel)
    {
        if(($nivel == CLIENTE) && (isset($_SESSION['he_cliente']))){
            return true;
        }else if(($nivel == COLABORADOR) && (isset($_SESSION['he_colaborador']))){
            return true;
        }else if(($nivel == FORNECEDOR) && (isset($_SESSION['he_fornecedor']))){
            return true;
        }else if(($nivel == REPRESENTANTE) && (isset($_SESSION['he_representante']))){
            return true;
        }else if(($nivel == GERENTE) && (isset($_SESSION['he_gerente']))){
            return true;
        }else if(($nivel == ADIMINISTRADOR) && (isset($_SESSION['he_administrador']))){
            return true;
        }else if(($nivel == FINANCEIRO) && (isset($_SESSION['he_master']))){
            return true;
        } else {
            throw new Exception("Não autorizado", 401);           
        }

    }


}