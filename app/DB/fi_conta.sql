CREATE TABLE fi_conta (
    fi_conta_id INT PRIMARY KEY AUTO_INCREMENT,
    fi_conta_nome VARCHAR(255) NOT NULL,
    usuarios_id INT,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id)
);