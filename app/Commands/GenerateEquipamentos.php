<?php
require_once __DIR__ . '/GenerateController.php';
/*$name = "Equipamento";
$modelName = "equipment";
$tableName = "equipments";
$fields = [
    ['name' => 'img1', 'type' => 'img', 'label' => 'imagem 1'],
    ['name' => 'img2', 'type' => 'img', 'label' => 'imagem 2'],
    ['name' => 'equipments_name', 'type' => 'text', 'label' => 'Nome do Equipamento'],
    ['name' => 'description', 'type' => 'textarea', 'label' => 'Description'],
    ['name' => 'price_per_day', 'type' => 'number', 'label' => 'Preço por dia'],   
    ['name' => 'availabilities', 'type' => 'select', 'label' => 'Disponibilidade'],  
    // Outros campos...
];*/

/*
//generate categoria
$name = "Categoria";
$modelName = "categorie";
$tableName = "categories";
$fields = [
    ['name' => 'categories_name', 'type' => 'text', 'label' => 'categoria'],
 
];
*/

/*
//generate testimonials
$name = "Depoimento";
$modelName = "testimonial";
$tableName = "testimonials";
$fields = [
    ['name' => 'customer', 'type' => 'text', 'label' => 'cliente'],
    ['name' => 'testimonials_text', 'type' => 'textarea', 'label' => 'depoimento'],
];
*/


//generate testimonials
/*$name = "Instancias";
$modelName = "equipmentinstance";
$tableName = "equipment_instances";
$fields = [
    ['name' => 'equipment_instances_status', 'type' => 'number', 'label' => 'status'],
    ['name' => 'identity', 'type' => 'text', 'label' => 'Identidade'],
    ['name' => 'equipments_id', 'type' => 'number', 'label' => 'equipamento'],
];*/

//generate images_galerie
/*$name = "images_galerie";
$modelName = "imagesgalerie";
$tableName = "images_galerie";
$fields = [
    ['name' => 'images_galerie_image', 'type' => 'img', 'label' => 'imagem'],
    ['name' => 'images_galerie_alt', 'type' => '~text', 'label' => 'descrião'],
];*/

/*$name = "Usuario";
$modelName = "usuario";
$tableName = "usuarios";
$fields = [
    ['name' => 'empresa', 'type' => 'text', 'label' => 'Empresa'],
    ['name' => 'email', 'type' => 'text', 'label' => 'Email'],
    ['name' => 'senha', 'type' => 'text', 'label' => 'senha'],
    ['name' => 'usuario', 'type' => 'text', 'label' => 'Usuário'],
    ['name' => 'nome_completo', 'type' => 'text', 'label' => 'nome completo'],
    ['name' => 'nivel_de_acesso', 'type' => 'number', 'label' => 'nível de acesso'],
    ['name' => 'nome_fantasia', 'type' => 'text', 'label' => 'nome fantasia'],
    ['name' => 'profissao', 'type' => 'text', 'label' => 'profissao'],
    ['name' => 'cpf', 'type' => 'text', 'label' => 'CPF'],
    ['name' => 'cnpj', 'type' => 'text', 'label' => 'cnpj'],
    ['name' => 'data_nascimento', 'type' => 'date', 'label' => 'data nascimento'],
    ['name' => 'fone', 'type' => 'text', 'label' => 'fone'],
    ['name' => 'ddd', 'type' => 'number', 'label' => 'ddd'],
    ['name' => 'celular', 'type' => 'text', 'label' => 'celular'],
    ['name' => 'cep', 'type' => 'text', 'label' => 'CEP'],
    ['name' => 'numero', 'type' => 'number', 'label' => 'numero'],
    ['name' => 'rua', 'type' => 'text', 'label' => 'rua'],
    ['name' => 'estado', 'type' => 'text', 'label' => 'estado'],
    ['name' => 'cidade', 'type' => 'text', 'label' => 'cidade'],
    ['name' => 'complemento', 'type' => 'text', 'label' => 'complemento'],
    ['name' => 'bairro', 'type' => 'text', 'label' => 'bairro'],
    ['name' => 'ie', 'type' => 'text', 'label' => 'ie'],
    ['name' => 'rg', 'type' => 'text', 'label' => 'rg'],
    ['name' => 'assinatura', 'type' => 'text', 'label' => 'assinatura']  
];*/

/*$name = "Pedido";
$modelName = "pedido";
$tableName = "";
$fields = [
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Representante'],
    ['name' => 'statusPedido_id', 'type' => 'number', 'label' => 'Status'],
    ['name' => 'pedido_dataCriacao', 'type' => 'date', 'label' => 'Data da criação'],

];*/

/*$name = "Pedidoitem";
$modelName = "pedido_item";
$tableName = "pedido_item";
$fields = [
    ['name' => 'pedidos_id', 'type' => 'number', 'label' => 'Pedido'],
    ['name' => 'pedido_item_largura', 'type' => 'number', 'label' => 'Largura'],
    ['name' => 'pedido_item_altura', 'type' => 'number', 'label' => 'Altura'],
    ['name' => 'pedido_item_quantidade', 'type' => 'number', 'label' => 'Quantidade']
];*/

/*$name = "Produtos";
$modelName = "produtos";
$tableName = "produtos";
$fields = [
    ['name' => 'produto_nome', 'type' => 'text', 'label' => 'Nome'],
    ['name' => 'produto_descricao', 'type' => 'text', 'label' => 'Descrição']
];*/

/*$name = "Tabela_preco";
$modelName = "tabela_preco";
$tableName = "tabela_preco";
$fields = [
    ['name' => 'produtos_id', 'type' => 'number', 'label' => 'Produto'],
    ['name' => 'tabela_preco_nome', 'type' => 'text', 'label' => 'Nome'],
    ['name' => 'tabela_preco_markup', 'type' => 'number', 'label' => 'Markup']
];*/

/*$name = "Tabela preco item";
$modelName = "tabela_preco_item";
$tableName = "tabela_preco_item";
$fields = [
    ['name' => 'tabela_preco_id', 'type' => 'number', 'label' => 'Tabela Preço'],
    ['name' => 'largura', 'type' => 'number', 'label' => 'Largura'],
    ['name' => 'altura', 'type' => 'number', 'label' => 'Altura'],
    ['name' => 'valor', 'type' => 'number', 'label' => 'Valor']

];*/

/*$name = "Composição do produto";
$modelName = "composicao";
$tableName = "composicao";
$fields = [
    ['name' => 'composicao_nome',   'type' => 'text', 'label' => 'Nome'],
    ['name' => 'composicao_tipo_id',   'type' => 'select', 'label' => 'Tipo'],
    ['name' => 'composicao_preco',  'type' => 'number', 'label' => 'Preço'],
    ['name' => 'composicao_pai_id', 'type' => 'number', 'label' => 'Composição pai'],
    ['name' => 'produtos_id',       'type' => 'number', 'label' => 'Produto'],
];*/

/*$name = "Tipo de composição";
$modelName = "composicao_tipo";
$tableName = "composicao_tipo";
$fields = [
    ['name' => 'composicao_tipo_nome',   'type' => 'text', 'label' => 'Nome']
];*/

/*$name = "Pedido item composição";
$modelName = "pedido_item_composicao";
$tableName = "pedido_item_composicao";
$fields = [
    ['name' => 'pedido_item_id',   'type' => 'number', 'label' => 'pedido_item_id'],
    ['name' => 'composicao_id',   'type' => 'number', 'label' => 'composicao_id'],
    ['name' => 'pedido_item_composicao_valor',  'type' => 'number', 'label' => 'valor no select'],
    ['name' => 'pedido_item_composicao_valorMonetario ', 'type' => 'number', 'label' => 'valor financeiro'],
];*/

/*$name = "Status pedido";
$modelName = "statusPedido";
$tableName = "statusPedido";
$fields = [
    ['name' => 'statusPedido_nome',   'type' => 'text', 'label' => 'status']
];*/

/*$name = "Fotos do produto";
$modelName = "produto_fotos";
$tableName = "produto_fotos";
$fields = [
    ['name' => 'produto_fotos_caminho', 'type' => 'img', 'label' => 'imagem'],
    ['name' => 'produtos_id', 'type' => 'number', 'label' => 'id do produto'],
];*/

/*$name = "Foto do ambiente";
$modelName = "foto_item_pedido";
$tableName = "foto_item_pedido";
$fields = [
    ['name' => 'foto_item_pedido_caminho', 'type' => 'img', 'label' => 'imagem'],
    ['name' => 'pedido_item_id', 'type' => 'number', 'label' => 'id do produto'],
];*/

/*$name = "Categorias de transações financeiras";
$modelName = "fi_categorias";
$tableName = "fi_categorias";
$fields = [
    ['name' => 'fi_categorias_nome',   'type' => 'text', 'label' => 'Nome'],
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuário']
];*/

/*$name = "Conta";
$modelName = "fi_conta";
$tableName = "fi_conta";
$fields = [
    ['name' => 'fi_conta_nome',   'type' => 'text', 'label' => 'Nome'],
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuário']
];*/

/*$name = "Transacoes";
$modelName = "fi_transacoes";
$tableName = "fi_transacoes";
$fields = [
    ['name' => 'tipo',   'type' => 'number', 'label' => 'Tipo'],
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuário'],
    ['name' => 'valor',   'type' => 'number', 'label' => 'Valor'],
    ['name' => 'data', 'type' => 'date', 'label' => 'data'],
    ['name' => 'data_pagamento', 'type' => 'date', 'label' => 'data pagamento'],
    ['name' => 'descricao',   'type' => 'text', 'label' => 'Descrição'],
    ['name' => 'fi_categorias_id',   'type' => 'number', 'label' => 'Categoria'],
    ['name' => 'numero_parcelas',   'type' => 'number', 'label' => 'numero parcelas'],
    ['name' => 'parcela_atual',   'type' => 'number', 'label' => 'parcela atual'],
    ['name' => 'fi_conta_id',   'type' => 'number', 'label' => 'Conta'],
    ['name' => 'fi_meio_id',   'type' => 'number', 'label' => 'Meio'],
];*/

/*$name = "Faturas";
$modelName = "faturas";
$tableName = "fi_faturas";
$fields = [
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuários'],
    ['name' => 'data_emissao', 'type' => 'date', 'label' => 'Data emissão'],
    ['name' => 'data_vencimento', 'type' => 'date', 'label' => 'Data vencimento'],
    ['name' => 'data_pagamento', 'type' => 'date', 'label' => 'Data pagamento'],
    ['name' => 'data_cancelamento	', 'type' => 'date', 'label' => 'Data cancelamento'],
    ['name' => 'valor_total', 'type' => 'number', 'label' => 'Valor total'],
    ['name' => 'descricao',   'type' => 'text', 'label' => 'Descrição']
    
];*/

/*$name = "Fornecedores";
$modelName = "fornecedores";
$tableName = "fornecedores";
$fields = [
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuário'],
    ['name' => 'informacoes_bancarias', 'type' => 'text', 'label' => 'Informações bancárias']
];*/

/*$name = "Representantes";
$modelName = "representantes";
$tableName = "representantes";
$fields = [
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuário']
];*/

/*$name = "status_fatura";
$modelName = "status_fatura";
$tableName = "status_fatura";
$fields = [
    ['name' => 'status_fatura_nome', 'type' => 'text', 'label' => 'Status Fatura']
];*/
/*$name = "usuario_tipo";
$modelName = "usuario_tipo";
$tableName = "usuario_tipo";
$fields = [
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuário'],
    ['name' => 'usuario_tipo', 'type' => 'number', 'label' => 'tipo usuario']
];*/

/*$name = "Ordem de producao";
$modelName = "ordem_producao";
$tableName = "ordem_producao";
$fields = [
    ['name' => 'ordem_producao_id', 'type' => 'number', 'label' => 'Usuário'],
    ['name' => 'pedidos_id', 'type' => 'select', 'label' => 'Pedido'],
    ['name' => 'empresa', 'type' => 'select', 'label' => 'Empresa'],
    ['name' => 'data_criacao', 'type' => 'date', 'label' => 'Data criação'],
    ['name' => 'data_inicio', 'type' => 'date', 'label' => 'Data início'],
    ['name' => 'data_finalizacao', 'type' => 'date', 'label' => 'Data término'],
    ['name' => 'operador', 'type' => 'select', 'label' => 'Operador'],
    ['name' => 'cliente', 'type' => 'select', 'label' => 'Cliente'],
    ['name' => 'data_confirmacao_pedido', 'type' => 'date', 'label' => 'Data confirmação do pedido'],
    ['name' => 'data_limite_producao', 'type' => 'date', 'label' => 'Data limite produção'],
    ['name' => 'data_limite_instalcao', 'type' => 'date', 'label' => 'Data limite instalação']
];*/

/*$name = "Itens da Ordem de Produção";
$modelName = "ordem_producao_item";
$tableName = "ordem_producao_item";
$fields = [
    ['name' => 'ordem_producao_id', 'type' => 'number', 'label' => 'Ordem produção'],
    ['name' => 'ambiente', 'type' => 'text', 'label' => 'Ambiente'],
    ['name' => 'modelo', 'type' => 'number', 'label' => 'modelo'],
    ['name' => 'largura', 'type' => 'number', 'label' => 'Largura'],
    ['name' => 'altura', 'type' => 'number', 'label' => 'Altura'],
    ['name' => 'cor', 'type' => 'text', 'label' => 'Cor'],
    ['name' => 'tipo_tela', 'type' => 'text', 'label' => 'Tipo de tela'],
    ['name' => 'tipo_conexao', 'type' => 'text', 'label' => 'Tipo de tela'],
    ['name' => 'largura_corte', 'type' => 'number', 'label' => 'Largura de corte'],
    ['name' => 'altura_corte', 'type' => 'number', 'label' => 'Altura de corte'],
    ['name' => 'tamanho_trilho_superior', 'type' => 'number', 'label' => 'Tamanho do trilho superior'],
    ['name' => 'tamanho_trilho_inferior', 'type' => 'number', 'label' => 'Tamanho do trilho inferior'],
    ['name' => 'instalacao', 'type' => 'text', 'label' => 'Intalação'],
    ['name' => 'tipo_trilho_superior', 'type' => 'text', 'label' => 'Tipo do trilho superior'],
    ['name' => 'tipo_trilho_infeior', 'type' => 'text', 'label' => 'Tipo do trilho inferior'],
    ['name' => 'fixacao_trilho_superior', 'type' => 'text', 'label' => 'Fixação do trilho superior'],
    ['name' => 'fixacao_trilho_inferior', 'type' => 'text', 'label' => 'Fixação do trilho inferior'],
    ['name' => 'posicao_escovas', 'type' => 'text', 'label' => 'Posição escovas'],
    ['name' => 'cor_escovas', 'type' => 'text', 'label' => 'Cor das Escovas'],
    ['name' => 'altura_escovas', 'type' => 'number', 'label' => 'Altura das escovas'],
];*/

/*$name = "Posições da linha da OP";
$modelName = "posicao_op";
$tableName = "posicao_op";
$fields = [
    ['name' => 'ativo', 'type' => 'number', 'label' => 'Posição ativa'],
    ['name' => 'descricao', 'type' => 'text', 'label' => 'Descrição'],
    ['name' => 'ordem', 'type' => 'number', 'label' => 'Ordem de exibição']
];*/

/*$name = "op item posicao";
$modelName = "op_item_posicao";
$tableName = "op_item_posicao";
$fields = [
    ['name' => 'posicao_op_id', 'type' => 'number', 'label' => 'posicao op id'],
    ['name' => 'ordem_producao_item_id', 'type' => 'number', 'label' => 'ordem_producao item id'],
    ['name' => 'conteudo_op_item', 'type' => 'text', 'label' => 'conteudo op item']
];*/

/*$name = "Movimentação de estoque";
$modelName = "movimentacao_estoque";
$tableName = "movimentacao_estoque";
$fields = [
    ['name' => 'produtos_id', 'type' => 'number', 'label' => 'Produto'],
    ['name' => 'quantidade', 'type' => 'number', 'label' => 'Quantidade'],
    ['name' => 'tipo_movimentacao', 'type' => 'number', 'label' => 'Tipo de movimentação'],
    ['name' => 'descricao', 'type' => 'text', 'label' => 'Descrição'],
    ['name' => 'data', 'type' => 'date', 'label' => 'Data da movimentação'],
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'Usuário'],
    ['name' => 'reserva_id', 'type' => 'number', 'label' => 'reserva'],
];*/

/*$name = "Reservas de estoque";
$modelName = "reserva";
$tableName = "reserva";
$fields = [
    ['name' => 'produtos_id', 'type' => 'number', 'label' => 'Produto'],
    ['name' => 'quantidade', 'type' => 'number', 'label' => 'Quantidade'],
    ['name' => 'tipo', 'type' => 'number', 'label' => 'Tipo de Reserva'],
    ['name' => 'reservado', 'type' => 'number', 'label' => 'Reservado'],
    ['name' => 'documento', 'type' => 'text', 'label' => 'Documento'],
    ['name' => 'descricao', 'type' => 'text', 'label' => 'Descrição']
];*/

/*$name = "Acessos dos usuarios";
$modelName = "usuario_acesso";
$tableName = "usuario_acesso";
$fields = [
    ['name' => 'usuarios_id', 'type' => 'number', 'label' => 'usuario'],
    ['name' => 'acesso', 'type' => 'number', 'label' => 'acesso']
];*/

$name = "Tickets";
$modelName = "Ticket";
$tableName = "tickets";
$fields = [
    [
        'name' => 'tickets_id',
        'type' => 'INT',
        'attributes' => 'AUTO_INCREMENT PRIMARY KEY',
        'label' => 'Ticket ID',
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'user_id',
        'type' => 'INT',
        'attributes' => '',
        'label' => 'User ID',
        'foreign' => [
            'table' => 'usuarios',
            'field' => 'usuarios_id',
            'nome' => 'usuario'
        ],
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'subject',
        'type' => 'VARCHAR(255)',
        'attributes' => 'NOT NULL',
        'label' => 'Subject',
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'imagem_perfil',
        'type' => 'img',
        'attributes' => '',
        'label' => 'Imagem de perfil',
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'description',
        'type' => 'TEXT',
        'attributes' => 'NOT NULL',
        'label' => 'Description',
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'status',
        'type' => 'enum',
        'values' => ['Open', 'In Progress', 'Closed'],
        'attributes' => "NOT NULL DEFAULT 'Open'",
        'label' => 'Status',
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'priority',
        'type' => 'enum',
        'values' => ['Low', 'Medium', 'High', 'Urgent'],
        'attributes' => "NOT NULL DEFAULT 'Medium'",
        'label' => 'Priority',
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'created_at',
        'type' => 'TIMESTAMP',
        'attributes' => 'DEFAULT CURRENT_TIMESTAMP',
        'label' => 'Created At',
        'ShowInTable' => 'true'
    ],
    [
        'name' => 'updated_at',
        'type' => 'TIMESTAMP',
        'attributes' => 'DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        'label' => 'Updated At',
        'ShowInTable' => 'true'
    ]
];
								
$generator = new app\Commands\GenerateController();
$result = $generator->generate($name ,$modelName, $tableName, $fields);
echo $result;