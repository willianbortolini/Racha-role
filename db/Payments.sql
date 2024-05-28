CREATE TABLE Payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    payer_id INT,
    payee_id INT,
    group_id INT,
    amount DECIMAL(10, 2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (payer_id) REFERENCES Users(user_id),
    FOREIGN KEY (payee_id) REFERENCES Users(user_id),
    FOREIGN KEY (group_id) REFERENCES Groups(group_id) ON DELETE CASCADE
);