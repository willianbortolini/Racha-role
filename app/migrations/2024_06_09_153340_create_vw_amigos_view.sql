CREATE VIEW vw_amigos AS
SELECT t.*, f_usuario_id.username AS usuario_id_nome, f_amigo_id.username AS amigo_id_nome
FROM amigos t
JOIN users f_usuario_id ON t.usuario_id = f_usuario_id.users_id
JOIN users f_amigo_id ON t.amigo_id = f_amigo_id.users_id
