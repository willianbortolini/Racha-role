CREATE TABLE tabela_preco_item (
    tabela_preco_item_id INT AUTO_INCREMENT PRIMARY KEY,
    tabela_preco_id INT,
    largura FLOAT,
    altura FLOAT,
    valor FLOAT,
    FOREIGN KEY (tabela_preco_id) REFERENCES tabela_preco(tabela_preco_id)
);
