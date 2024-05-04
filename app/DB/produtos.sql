CREATE TABLE produtos (
    produtos_id INT AUTO_INCREMENT PRIMARY KEY,
    produtos_nome VARCHAR(200) NOT NULL,
    produtos_descricao TEXT,
    tabela_preco_id INT,
    produtos_usaTabelaPreco TINYINT(1)
);
