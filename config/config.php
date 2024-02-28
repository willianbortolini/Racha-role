<?php

if (strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
    define("SERVIDOR", "localhost");
    define("BANCO", "cursoswill");
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

#recaptcha
define("SITEKEY", "6LeqisoZAAAAAM3vBJYQjtZ9P8gyBdFeE0mbsorb");
define("SECRETKEY", "6LeqisoZAAAAALykk1VnViOydSPIPu9t6Gi6Dcii");

//niveis de acesso
define("REPRESENTANTE", 3);
define("ADIMINISTRADOR", 4);

//mercado livre
define('TOKEM_MP', 'APP_USR-351519828361761-012921-c9f0fcbfd43f5e2570fc93c57a7148c6-306339298');
define('KEY_MP', 'APP_USR-4c07e959-79e8-44f0-93d5-5b94c173d177');

define('TOKEM_MP_TESTE', 'TEST-351519828361761-012921-52e119ee341ff93e6d5b14797bb0ca57-306339298');
define('KEY_MP_TESTE', 'TEST-cd7fb534-9799-402e-aae0-bb180c275b75');
