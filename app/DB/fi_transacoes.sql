CREATE TABLE fi_transacoes (
    fi_transacoes_id INT PRIMARY KEY AUTO_INCREMENT,
    usuarios_id INT,
    tipo INT,
    valor DECIMAL(10, 2) NOT NULL,
    data DATE NOT NULL,
    data_pagamento DATE,
    descricao VARCHAR(255),
    fi_categorias_id INT,
    numero_parcelas INT,
    parcela_atual INT,
    fi_conta_id INT,
    fi_meio_id INT,
    FOREIGN KEY (fi_categorias_id) REFERENCES fi_categorias(fi_categorias_id),
    FOREIGN KEY (fi_conta_id) REFERENCES fi_conta(fi_conta_id),
    FOREIGN KEY (fi_meio_id) REFERENCES fi_meio(fi_meio_id),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id)
);