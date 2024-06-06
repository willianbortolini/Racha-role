CREATE VIEW vw_saldos AS
SELECT t.*, f_devedor_id.username AS users_nome, f_credor_id.username AS users_nome
FROM saldos t
JOIN users f_devedor_id ON t.devedor_id = f_devedor_id.users_id
JOIN users f_credor_id ON t.credor_id = f_credor_id.users_id
