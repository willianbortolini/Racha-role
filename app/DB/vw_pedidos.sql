ALTER VIEW vw_pedidos AS
SELECT 
    pedidos.pedidos_id,
    pedidos.usuarios_id,
    pedidos.codigo_acesso_cliente,
    usuarios.usuario,
    statusPedido.statusPedido_nome,
    statusPedido.statusPedido_id,    
    pedidos.pedido_dataCriacao,    
    pedidos.pedidos_nome,
    ordem_producao.ordem_producao_id,
    ordem_producao.data_inicio,
    pedidos.data_pedido,
    pedidos.data_aprovacao,
    SUM(pedido_item.pedido_item_valor_total) AS total_valor_pedido_item,
    SUM(pedido_item.pedido_item_valor_total *  pedido_item.pedido_item_markup) AS total_valor_venda,
    pedidos.cliente,
    cliente.usuario cliente_nome
FROM pedidos
JOIN statusPedido ON 
    pedidos.statusPedido_id = statusPedido.statusPedido_id
LEFT JOIN usuarios ON
    usuarios.usuarios_id = pedidos.usuarios_id
LEFT JOIN usuarios cliente ON
    cliente.usuarios_id = pedidos.cliente
LEFT JOIN pedido_item ON
    pedidos.pedidos_id = pedido_item.pedidos_id
LEFT JOIN ordem_producao ON
ordem_producao.pedidos_id = pedidos.pedidos_id
GROUP BY
    usuarios.usuario,
    statusPedido.statusPedido_nome,
    statusPedido.statusPedido_id,
    pedidos.usuarios_id,
    pedidos.pedido_dataCriacao,
    pedidos.pedidos_id,
    pedidos.pedidos_nome;


