<?php
require_once __DIR__ . '/GenerateController.php';

/*$name = "Cursos";
$modelName = "Cursos";
$tableName = "Cursos";
$fields = [
    ['name' => 'nome',   'type' => 'text', 'label' => 'Nome do curso'],
    ['name' => 'area',   'type' => 'text', 'label' => 'Area'],
    ['name' => 'descricao',   'type' => 'text', 'label' => 'Descrição'],
    ['name' => 'desconto',   'type' => 'number', 'label' => 'Desconto'],
    ['name' => 'preco_original',   'type' => 'number', 'label' => 'Preço original'],
    ['name' => 'preco',   'type' => 'number', 'label' => 'Preço'],
    ['name' => 'professor_id',   'type' => 'select', 'label' => 'professor'],
    ['name' => 'url_imagem',   'type' => 'img', 'label' => 'Imagem do curso'],
];*/


/*$name = "Recebimentos";
$modelName = "Recebimentos";
$tableName = "recebimentos";
$fields = [
    ['name' => 'usuarios_id',   'type' => 'number', 'label' => 'Usuario'],
    ['name' => 'cursos_id',   'type' => 'number', 'label' => 'Curso'],
    ['name' => 'valor',   'type' => 'number', 'label' => 'Valor'],
    ['name' => 'metodo',   'type' => 'number', 'label' => 'Método'],
    ['name' => 'id_mercado_pago',   'type' => 'text', 'label' => 'Id mercado pago'],
    ['name' => 'email',   'type' => 'text', 'label' => 'Email'],
    ['name' => 'recebimento_data',   'type' => 'date', 'label' => 'Data do recebimento'],
    ['name' => 'recebimento_status',   'type' => 'number', 'label' => 'Status do recebimento'],
    ['name' => 'recebimento_data_liberacao',   'type' => 'date', 'label' => 'Data da liberação do recebimento']
];*/

$name = "inventario_compartilhado";
$modelName = "inventario_compartilhado";
$tableName = "inventario_compartilhado";
$fields = [
    ['name' => 'inventario_id',   'type' => 'number', 'label' => 'Inventario'],
    ['name' => 'usuario_id',   'type' => 'number', 'label' => 'usuario']
];

/*$name = "inventario";
$modelName = "inventario";
$tableName = "inventario";
$fields = [
    ['name' => 'nome',   'type' => 'text', 'label' => 'Nome'],
    ['name' => 'localizacao',   'type' => 'text', 'label' => 'Localizacao'],
    ['name' => 'responsavel',   'type' => 'text', 'label' => 'Responsavel'],
    ['name' => 'usuarios_id',   'type' => 'number', 'label' => 'Usuario'],
];*/

/*$name = "matriculas";
$modelName = "matriculas";
$tableName = "matriculas";
$fields = [
    ['name' => 'usuarios_id',   'type' => 'number', 'label' => 'Usuario'],
    ['name' => 'cursos_id',   'type' => 'number', 'label' => 'Curso'],
    ['name' => 'recebimentos_id',   'type' => 'number', 'label' => 'Recebimento']
];*/


$generator = new app\Commands\GenerateController();
//$result = $generator->generate($name ,$modelName, $tableName, $fields);
echo $result;