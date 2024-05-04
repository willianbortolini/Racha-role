
CREATE TABLE fi_faturas (
    fi_faturas_id INT AUTO_INCREMENT PRIMARY KEY,
    fornecedor INT NOT NULL,
    empresa INT NOT NULL,
    data_emissao DATE NOT NULL,
    data_vencimento DATE NOT NULL,
    data_pagamento DATE NULL,
    data_cancelamento DATE NULL,
    valor_total DECIMAL(15, 2) NOT NULL,
    descricao TEXT,
    permite_editar TINYINT DEFAULT 1,
    FOREIGN KEY (fornecedor) REFERENCES usuarios(usuarios_id)
    FOREIGN KEY (empresa) REFERENCES usuarios(usuarios_id)
);