CREATE TABLE produto_fotos (
    produto_fotos_id INT AUTO_INCREMENT PRIMARY KEY,
    produtos_id INT,
    produto_fotos_caminho VARCHAR(255),
    FOREIGN KEY (produtos_id) REFERENCES produtos(produtos_id)
);