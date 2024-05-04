CREATE TABLE `movimentacao_estoque` (
  `movimentacao_estoque_id` int(11) NOT NULL,
  `produtos_id` int(11) NOT NULL,
  `quantidade` decimal(8,2) NOT NULL,
  `tipo_movimentacao` int(11) NOT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `usuarios_id` int(11) NOT NULL,
  `reserva_id` int(11) DEFAULT NULL
)

ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`movimentacao_estoque_id`),
  ADD KEY `FK_PRODUTOS` (`produtos_id`);

ALTER TABLE `movimentacao_estoque`
  MODIFY `movimentacao_estoque_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `movimentacao_estoque`
  ADD CONSTRAINT `FK_PRODUTOS` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`produtos_id`);