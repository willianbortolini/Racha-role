CREATE TABLE pagamentos (
    pagamentos_id INT AUTO_INCREMENT PRIMARY KEY,
    pagador INT NOT NULL,
    recebedor INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pagador) REFERENCES users(users_id),
    FOREIGN KEY (recebedor) REFERENCES users(users_id)
);