<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Usuarios_gruposService;

class Usuarios_gruposController extends Controller
{

    public function __construct()
    {
        UtilService::validaUsuario();
    }

}
