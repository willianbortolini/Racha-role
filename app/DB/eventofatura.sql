CREATE EVENT `criaFaturaW9b2`
ON SCHEDULE EVERY 1 MONTH
STARTS LAST_DAY(NOW()) + INTERVAL 1 DAY
DO
    INSERT INTO fi_faturas (fornecedor, empresa, data_emissao, data_vencimento, valor_total, descricao, permite_editar)
    SELECT 1 fornecedor,
    usuario_tipo.empresa empresa,    
    CURDATE() data_emissao,
    DATE_ADD(LAST_DAY(NOW()), INTERVAL 10 DAY) data_vencimento,
    COUNT(usuario_tipo.empresa)*25+200 valor_total,
    'Fatura W9B2' descricao,
    0 permite_editar
    FROM usuario_tipo
    WHERE usuario_tipo.usuario_tipo = 3
    GROUP BY usuario_tipo.empresa


