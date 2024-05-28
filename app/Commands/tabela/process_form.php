<?php

if ($_SERVER["HTTP_HOST"] !== 'localhost') {
    echo "<h1>Acesso negado</h1>";
    exit;
}

require_once __DIR__ . '\..\GenerateController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $params = [
        'name' => $_POST['name'],
        'tableName' => $_POST['tableName'],
        'fields' => array_map(function($field) {
            return [
                'name' => $field['name'],
                'type' => $field['type'],
                'attributes' => $field['attributes'],
                'label' => $field['label'],
                'ShowInTable' => isset($field['ShowInTable']) && $field['ShowInTable'] == 'true',
                'generateInput' => $field['generateInput'] ?? null,
                'validation' => $field['validation'] ?? null,
                'foreign' => (isset($field['foreign']) && ($field['foreign']['table']) != '')? [
                    'table' => $field['foreign']['table'],
                    'field' => $field['foreign']['field'],
                    'nome' => $field['foreign']['nome'],
                ] : null,
            ];
        }, $_POST['fields'])
    ];
    // Salvar os parâmetros em um arquivo JSON
    $json_data = json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $json_file = __DIR__ . '/'.$_POST['name'].'.json';
    file_put_contents($json_file, $json_data);

    //$generator = new app\Commands\GenerateController();
    //$result = $generator->generate($params);

    //echo $result;
}
?>
