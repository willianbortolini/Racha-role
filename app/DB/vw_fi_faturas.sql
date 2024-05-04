ALTER VIEW vw_fi_faturas AS
    SELECT  fi_faturas.*, fornecedor.usuario fornecedor_nome,
    CASE 
            WHEN fi_faturas.data_cancelamento IS NOT NULL THEN 'Cancelado'
            WHEN fi_faturas.data_pagamento IS NOT NULL THEN 'Pago'
            WHEN fi_faturas.data_vencimento < CURDATE() THEN 'Vencido'
            ELSE 'Pendente'
        END AS status_fatura
    FROM fi_faturas
    INNER JOIN usuarios fornecedor ON
    fornecedor.usuarios_id =  fornecedor