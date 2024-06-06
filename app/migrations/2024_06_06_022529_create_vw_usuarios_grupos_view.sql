CREATE VIEW vw_usuarios_grupos AS
SELECT t.*, f_users_id.username AS users_nome, f_grupos_id.nome AS grupos_nome
FROM usuarios_grupos t
JOIN users f_users_id ON t.users_id = f_users_id.users_id
JOIN grupos f_grupos_id ON t.grupos_id = f_grupos_id.grupos_id
