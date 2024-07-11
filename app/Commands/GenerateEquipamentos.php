<?php
if ($_SERVER["HTTP_HOST"] !== 'localhost') {
    echo "<h1>Acesso negado</h1>";
    exit;
}

require_once __DIR__ . '/GenerateController.php';

// Carregar os parâmetros do arquivo JSON
$jsonString = file_get_contents(__DIR__ .'/tabela/pagamentos.json');
$params = json_decode($jsonString, true);
								
$generator = new app\Commands\GenerateController();
$result = $generator->generate($params);
echo $result;
