CREATE VIEW vw_movimentacao_estoque AS
SELECT movimentacao_estoque.*, produtos.produtos_nome, usuarios.usuario 
FROM movimentacao_estoque
INNER JOIN produtos ON
produtos.produtos_id = movimentacao_estoque.produtos_id
INNER JOIN usuarios ON
usuarios.usuarios_id = movimentacao_estoque.usuarios_id