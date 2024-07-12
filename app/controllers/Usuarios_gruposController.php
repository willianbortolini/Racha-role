<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Usuarios_gruposService;
use app\models\service\Service;

class Usuarios_gruposController extends Controller
{
    private $tabela = "usuarios_grupos";
    private $campo = "usuarios_grupos_id";

    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function usuariosDoGrupo($id)
    {
        echo json_encode(Service::get($this->tabela, "grupos_id", $id, true));
    }

}
