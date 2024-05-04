DELIMITER //
CREATE TRIGGER recalcula_quantidade_reservada AFTER INSERT ON reserva
FOR EACH ROW
BEGIN
    -- Atualiza a quantidade reservada na tabela produto
    UPDATE produtos
    SET estoque_quantidade_reservada = (
        SELECT SUM(quantidade)
        FROM reserva
        WHERE produtos_id = NEW.produtos_id
        AND reservado = 1 
    )
    WHERE produtos_id = NEW.produtos_id;
END;
//

CREATE TRIGGER recalcula_quantidade_reservada_update AFTER UPDATE ON reserva
FOR EACH ROW
BEGIN
    -- Atualiza a quantidade reservada na tabela produto
    UPDATE produto
    SET estoque_quantidade_reservada = (
        SELECT SUM(quantidade)
        FROM reserva
        WHERE produtos_id = NEW.produtos_id
        AND reservado = 1 
    )
    WHERE produtos_id = NEW.produtos_id;
END;

CREATE TRIGGER recalcula_quantidade_reservada_delete AFTER DELETE ON reserva
FOR EACH ROW
BEGIN
    -- Atualiza a quantidade reservada na tabela produto
    UPDATE produto
    SET estoque_quantidade_reservada = (
        SELECT SUM(quantidade)
        FROM reserva
        WHERE produtos_id = NEW.produtos_id
        AND reservado = 1 
    )
    WHERE produtos_id = OLD.produtos_id;
END;
//
DELIMITER ;
