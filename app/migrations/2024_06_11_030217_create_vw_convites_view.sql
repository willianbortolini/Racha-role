CREATE VIEW vw_convites AS
SELECT t.*, f_usuario_id.username AS usuario_id_nome, f_convidado_id.username AS convidado_id_nome
FROM convites t
JOIN users f_usuario_id ON t.usuario_id = f_usuario_id.users_id
JOIN users f_convidado_id ON t.convidado_id = f_convidado_id.users_id
