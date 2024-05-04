CREATE VIEW vw_produtos_estoque AS
SELECT produtos.*, SUM(reserva.quantidade) AS quantidade_reservada 
FROM produtos 
LEFT JOIN reserva ON reserva.produtos_id = produtos.produtos_id AND reserva.reservado = 1
GROUP BY produtos.produtos_id;