CREATE TABLE recebimentos (
    recebimentos_id INT AUTO_INCREMENT PRIMARY KEY,
    usuarios_id INT NOT NULL,
    cursos_id INT NOT NULL,
    valor FLOAT(10,2),
    metodo INT,
    transacao_id INT,
    recebimento_data DATETIME,
    recebimento_status INT,
    recebimento_data_liberacao DATETIME,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id),
    FOREIGN KEY (cursos_id) REFERENCES cursos(cursos_id)
);