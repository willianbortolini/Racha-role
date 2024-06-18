CREATE TABLE saldos (
    saldos_id INT AUTO_INCREMENT PRIMARY KEY,
    devedor_id INT NOT NULL,
    credor_id INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (devedor_id) REFERENCES users(users_id),
    FOREIGN KEY (credor_id) REFERENCES users(users_id)
);