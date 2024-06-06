CREATE VIEW vw_participantes_despesas AS
SELECT t.*, f_despesas_id.descricao AS despesas_nome, f_users_id.username AS users_nome
FROM participantes_despesas t
JOIN despesas f_despesas_id ON t.despesas_id = f_despesas_id.despesas_id
JOIN users f_users_id ON t.users_id = f_users_id.users_id
