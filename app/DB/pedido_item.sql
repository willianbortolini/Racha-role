CREATE TABLE pedido_item (
    pedido_item_id INT AUTO_INCREMENT PRIMARY KEY,
    pedidos_id INT,
    pedido_item_largura FLOAT,
    pedido_item_altura FLOAT,
    pedido_item_quantidade FLOAT,
    pedido_item_valor_total FLOAT,
    pedido_item_valor_unitario FLOAT,
    produtos_id INT,
    pedido_item_descricao VARCHAR(255),
    FOREIGN KEY (pedidos_id) REFERENCES pedidos(pedidos_id),
    FOREIGN KEY (produtos_id) REFERENCES produtos(produtos_id)
);
