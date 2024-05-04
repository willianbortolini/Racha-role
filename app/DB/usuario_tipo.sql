CREATE TABLE usuario_tipo(
    usuario_tipo_id INT AUTO_INCREMENT PRIMARY KEY,
    usuarios_id INT NOT NULL,
    usuario_tipo INT NOT NULL,
    empresa INT NOT NULL,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id),
    FOREIGN KEY (empresa) REFERENCES usuarios(usuarios_id),
    UNIQUE (usuarios_id, usuario_tipo, empresa)
);