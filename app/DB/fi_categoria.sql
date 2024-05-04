CREATE TABLE fi_categorias (
    fi_categorias_id INT PRIMARY KEY AUTO_INCREMENT,
    fi_categorias_nome VARCHAR(255) NOT NULL,
    usuarios_id INT,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id)
);