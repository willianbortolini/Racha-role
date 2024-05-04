CREATE VIEW vw_fi_transacoes AS
SELECT fi_transacoes.*, fi_meio.fi_meio_nome, fi_conta.fi_conta_nome, fi_categorias.fi_categorias_nome,
 CASE 
        WHEN fi_transacoes.tipo = 0 THEN 'Entrada'
        WHEN fi_transacoes.tipo = 1 THEN 'Saída'
        ELSE 'Tipo não definido' 
    END AS tipo_nome
FROM fi_transacoes
INNER JOIN fi_meio ON
fi_meio.fi_meio_id = fi_transacoes.fi_meio_id
INNER JOIN fi_conta ON
fi_conta.fi_conta_id = fi_transacoes.fi_conta_id
INNER JOIN fi_categorias ON
fi_categorias.fi_categorias_id = fi_transacoes.fi_categorias_id