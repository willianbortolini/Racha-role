<?php

define('DOCKER_CONTAINER', false);

if (strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
    define("SERVIDOR", "localhost");
    define("BANCO", "invtrac");
    define("USUARIO", "root");
    define("SENHA", "");
    define("CHARSET", "UTF8");
    define("DESENV", "true");
} else {
    define("SERVIDOR", "localhost");
    define("BANCO", "u296776918_invtrackDB");
    define("USUARIO", "u296776918_userInvtrack");
    define("SENHA", "Previsivel123");
    define("CHARSET", "UTF8");
    define("DESENV", "false");
}


define('CONTROLLER_PADRAO', 'home');
define('METODO_PADRAO', 'index');
define('NAMESPACE_CONTROLLER', 'app\\controllers\\');
define('TIMEZONE', "America/Fortaleza");
define('CAMINHO', realpath('./'));
define("TITULO_SITE", "Sua empresa online");

//constantes de maquina
define("TEMPO_CICLO", "120");

//define('URL_BASE', 'http://' . $_SERVER["HTTP_HOST"].'/');
//define('URL_IMAGEM', "http://". $_SERVER['HTTP_HOST'] . "/app/upload/");


if ((strpos($_SERVER["HTTP_HOST"], "localhost") !== false) or ($_SERVER["HTTP_HOST"] == '192.168.1.14')) {
    define('URL_BASE', 'http://' . $_SERVER["HTTP_HOST"] . '/');
    define('URL_IMAGEM', 'http://' . $_SERVER['HTTP_HOST'] . '/app/upload/');
    define('URL_IMAGEM_150', 'http://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_150_');
    define('URL_IMAGEM_500', 'http://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_500_');
} else {
    define('URL_BASE', 'https://' . $_SERVER["HTTP_HOST"] . '/');
    define('URL_IMAGEM', 'https://' . $_SERVER['HTTP_HOST'] . '/app/upload/');
    define('URL_IMAGEM_150', 'https://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_150_');
    define('URL_IMAGEM_500', 'https://' . $_SERVER['HTTP_HOST'] . '/app/upload/mini_500_');
}



define("SESSION_LOGIN", "usuario_logado");
define("CAMINHO_ABSOLUTO", realpath('./') . '/app/upload/');

$config_upload["verifica_extensao"] = false;
$config_upload["extensoes"] = array(".gif", ".jpeg", ".png", ".bmp", ".jpg", "heif", "heic");
$config_upload["extensoes_imagem"] = array(".gif", ".jpeg", ".png", ".bmp", ".jpg", "heif", "heic");
$config_upload["verifica_tamanho"] = true;
$config_upload["tamanho"] = 3097152;
$config_upload["caminho_absoluto"] = realpath('./') . '/app/upload/';
$config_upload["renomeia"] = true;

#recaptcha
define("SITEKEY", "6LeqisoZAAAAAM3vBJYQjtZ9P8gyBdFeE0mbsorb");
define("SECRETKEY", "6LeqisoZAAAAALykk1VnViOydSPIPu9t6Gi6Dcii");

//tipos de pedido
define("ORCAMENTO", 1);
define("PEDIDO", 2);
define("PEDIDO_APROVADO", 3);
define("PEDIDO_EMTREGUE", 4);

//niveis de acesso
define("CLIENTE", 20);
define("COLABORADOR", 25);
define("FORNECEDOR", 30);
define("REPRESENTANTE", 50);
define("GERENTE", 60);
define("ADIMINISTRADOR", 80);
define("FINANCEIRO", 100);

//tipo de reserva
define("RESERVA_OP", 1);

//tipo movimentação
define("MOVIMENTACAO_RESERVA", 1);
define("MOVIMENTACAO_ENTRADA", 2);
define("MOVIMENTACAO_SAIDA", 3);

//Acessos
define("PERMITE_CADASTRARCLIENTENOPEDIDO", 1);
define("TELA_HOME", 1000);
define("TELA_FINANCEIRO", 1100);
define("TELA_FINANCEIRO_FATURAS", 1101);
define("TELA_PRODUCAO", 1200);
define("TELA_PRODUCAO_ORDEMDEPRODUCAO", 1201);
define("TELA_PRODUCAO_PEDIDOSORDENS", 1202);
define("TELA_PRODUCAO_POSICOESORDEM", 1203);
define("TELA_ESTOQUE", 1300);
define("TELA_ESTOQUE_CONSULTA", 1301);
define("TELA_ESTOQUE_RESERVAS", 1302);
define("TELA_ESTOQUE_MOVIMENTACOES", 1303);
define("TELA_ESTOQUE_MOVIMENTACAOMANUAL", 1304);
define("TELA_ESTOQUE_RESERVASPORPEDIDO", 1305);
define("TELA_USUARIOS", 1400);
define("TELA_USUARIOS_REPRESENTANTES", 1401);
define("TELA_USUARIOS_CLIENTES", 1402);
define("TELA_USUARIOS_COLABORADORES", 1403);
define("TELA_PRODUTOS", 1500);
define("TELA_PRODUTOS_PRODUTOS", 1501);
define("TELA_PRODUTOS_INSUMOS", 1502);
define("TELA_PRODUTOS_COMPOSICAOPADRAO", 1503);
define("TELA_PRODUTOS_TABELADEPRECO", 1504);