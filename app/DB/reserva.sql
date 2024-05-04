CREATE TABLE `reserva` (
  `reserva_id` int(11) NOT NULL,
  `produtos_id` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `quantidade` decimal(8,2) NOT NULL,
  `reservado` int(1) NOT NULL,
  `documento` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL
)

ALTER TABLE `reserva`
  ADD PRIMARY KEY (`reserva_id`),
  ADD KEY `FK_PRODUTO` (`produtos_id`);

  ALTER TABLE `reserva`
  MODIFY `reserva_id` int(11) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `reserva`
  ADD CONSTRAINT `FK_PRODUTO` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`produtos_id`);