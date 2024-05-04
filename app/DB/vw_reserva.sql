CREATE VIEW vw_reserva AS
SELECT reserva.*, produtos.produtos_nome 
FROM reserva 
INNER JOIN produtos ON
produtos.produtos_id = reserva.produtos_id