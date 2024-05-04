CREATE TABLE pedidos (
    pedidos_id INT AUTO_INCREMENT PRIMARY KEY,
    pedidos_nome VARCHAR(200),
    usuarios_id INT,
    statusPedido_id INT,
    pedido_dataCriacao DATETIME,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id),
    FOREIGN KEY (statusPedido_id) REFERENCES statusPedido(statusPedido_id)
);
