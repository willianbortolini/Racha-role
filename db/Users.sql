CREATE TABLE Users (
    users_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    politica SMALLINT,
    cookies SMALLINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);