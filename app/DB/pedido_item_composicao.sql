CREATE TABLE pedido_item_composicao (
    pedido_item_composicao_id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_item_id INT,
    composicao_id INT,
    pedido_item_composicao_valor FLOAT,
    pedido_item_composicao_valorMonetario FLOAT,
    pedido_item_composicao_descricao text,
    FOREIGN KEY (pedido_item_id) REFERENCES pedido_item(pedido_item_id),
    FOREIGN KEY (composicao_id) REFERENCES composicao(composicao_id)
);
