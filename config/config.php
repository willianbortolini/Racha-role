<?php

if (strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
    define("SERVIDOR", "localhost");
    define("BANCO", "cadeopixdb");
    define("USUARIO", "root");
    define("SENHA", "");
    define("CHARSET", "UTF8");
} else {
    define("SERVIDOR", "localhost");
    define("BANCO", "u296776918_invtrackDB");
    define("USUARIO", "u296776918_userInvtrack");
    define("SENHA", "Previsivel123");
    define("CHARSET", "UTF8");
}


define('DOCKER_CONTAINER', false);
define('CONTROLLER_PADRAO', 'home');
define('METODO_PADRAO', 'index');
define('NAMESPACE_CONTROLLER', 'app\\controllers\\');
define('TIMEZONE', "America/Fortaleza");
define('CAMINHO', realpath('./'));
define("TITULO_SITE", "Sua empresa online");


if (strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
    define("PRODUCAO", false);
    define('URL_BASE', 'http://' . $_SERVER["HTTP_HOST"] . '/');
    define('URL_IMAGEM', 'http://' . $_SERVER['HTTP_HOST'] . '/app/upload/');
    define('URL_IMAGEM_150', 'http://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_150_');
    define('URL_IMAGEM_500', 'http://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_500_');
} else {
    define("PRODUCAO", true);
    define('URL_BASE', 'https://' . $_SERVER["HTTP_HOST"] . '/');
    define('URL_IMAGEM', 'https://' . $_SERVER['HTTP_HOST'] . '/app/upload/');
    define('URL_IMAGEM_150', 'https://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_150_');
    define('URL_IMAGEM_500', 'https://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_500_');
}

define("CAMINHO_ABSOLUTO",realpath('./'). '/app/upload/');

$config_upload["verifica_extensao"] = false;
$config_upload["extensoes"] = array(".gif", ".jpeg", ".png", ".bmp", ".jpg");
$config_upload["verifica_tamanho"] = true;
$config_upload["tamanho"] = 3097152;
$config_upload["caminho_absoluto"] = realpath('./') . '/app/upload/';
$config_upload["renomeia"] = true;
