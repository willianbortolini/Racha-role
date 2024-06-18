CREATE TABLE users (
    users_id INT AUTO_INCREMENT PRIMARY KEY,
    usernome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(20) ,
    password VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) ,
    politica smallint(1) NOT NULL DEFAULT 1,
    cookies smallint(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);