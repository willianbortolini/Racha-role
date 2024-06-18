CREATE TABLE convites (
    convites_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    convidado_id INT NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) ,
    status ENUM('Pendente', 'Aceito', 'Recusado') NOT NULL DEFAULT 'Pendente',
    aceitado_em TIMESTAMP ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES users(users_id),
    FOREIGN KEY (convidado_id) REFERENCES users(users_id)
);