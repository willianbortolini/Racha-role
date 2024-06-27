CREATE TABLE participantes_despesas (
    participantes_despesas_id INT AUTO_INCREMENT PRIMARY KEY,
    despesas_id INT NOT NULL,
    users_id INT NOT NULL,
    devendo_para INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    valor_pago DECIMAL(10, 2) ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (despesas_id) REFERENCES despesas(despesas_id),
    FOREIGN KEY (users_id) REFERENCES users(users_id),
    FOREIGN KEY (devendo_para) REFERENCES users(users_id)
);