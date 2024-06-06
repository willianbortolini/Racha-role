CREATE TABLE usuarios_grupos (
    usuarios_grupos_id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT NOT NULL,
    grupos_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(users_id),
    FOREIGN KEY (grupos_id) REFERENCES grupos(grupos_id)
);