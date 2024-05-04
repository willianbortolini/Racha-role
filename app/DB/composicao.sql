
CREATE TABLE composicao (
    composicao_id INT PRIMARY KEY AUTO_INCREMENT,
    composicao_nome VARCHAR(255) NOT NULL,
    composicao_tipo_id INT,
    composicao_preco DECIMAL(10, 2),
    composicao_pai_id INT,
    produtos_id INT,
    composicao_formula varchar(255),
    composicao_padrao_id INT,
    FOREIGN KEY (produtos_id) REFERENCES produtos(produtos_id),
    FOREIGN KEY (composicao_tipo_id) REFERENCES composicao_tipo(composicao_tipo_id)
);