<?php
use app\models\service\Service;

class Core
{
    private $controller;
    private $metodo;
    private $parametros = array();

    public function __construct()
    {
        $this->verificaUri();
    }

    public function run()
    {

        $controllerCorrente = $this->getController();

        try {
            $c = new $controllerCorrente;
            call_user_func_array(array($c, $this->getMetodo()), $this->getParametros());
        } catch (ArgumentCountError $e) {
            throw new Exception("Erro na linha: " . $e->getLine() . " do arquivo " . $e->getFile() . " <br> O número de argumentos passados não corresponde ao esperado <br><br>");
        }
    }
    public function verificaUri()
    {
        $url = explode("index.php", $_SERVER["PHP_SELF"]);
        $url = end($url);

        if ($url != "") {
            $url = explode('/', $url);
            array_shift($url);
            if (isset($url[0])) {
                //Pega o Controller
                $this->controller = ucfirst($url[0]) . "Controller";
                array_shift($url);
                //Pega o Método
                if (isset($url[0])) {
                    $this->metodo = $url[0];
                    array_shift($url);
                } else {
                    $this->metodo = METODO_PADRAO;
                }

                //Pegar os parâmetros
                if (isset($url[0])) {
                    $this->parametros = array_filter($url);
                }
            } else {
                $this->controller = ucfirst(CONTROLLER_PADRAO) . "Controller";
                $this->metodo = "locadora";
            }
        } else {
            $this->controller = ucfirst(CONTROLLER_PADRAO) . "Controller";
            $this->metodo = METODO_PADRAO;
        }

    }
    public function getController()
    {
        if (class_exists(NAMESPACE_CONTROLLER . $this->controller)) {
            return NAMESPACE_CONTROLLER . $this->controller;
        } else {
            throw new Exception("Página não encontrada", 404);
        }
    }

    public function getMetodo()
    {
        if (method_exists(NAMESPACE_CONTROLLER . $this->controller, $this->metodo)) {
            return $this->metodo;
        } else {
            throw new Exception("Método não encontrado", 500);
        }
    }

    public function getParametros()
    {
        $array = $this->parametros;
        setcookie('parametro1', isset($array[0]) ? $array[0] : '', time() + 3600, '/');
        setcookie('parametro2', isset($array[1]) ? $array[1] : '', time() + 3600, '/');
        setcookie('parametro3', isset($array[2]) ? $array[2] : '', time() + 3600, '/');
        return $this->parametros;
    }


}