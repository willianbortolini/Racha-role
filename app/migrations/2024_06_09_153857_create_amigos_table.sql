CREATE TABLE amigos (
    amigos_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    amigo_id INT NOT NULL,
    status ENUM('Pendente', 'Aceito', 'Recusado') NOT NULL DEFAULT 'Pendente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES users(users_id),
    FOREIGN KEY (amigo_id) REFERENCES users(users_id)
);