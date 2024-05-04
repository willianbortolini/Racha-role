START TRANSACTION;
CREATE TABLE `usuario_acesso` (
  `usuario_acesso_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `acesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `usuario_acesso`
  ADD PRIMARY KEY (`usuario_acesso_id`);

ALTER TABLE `usuario_acesso`
  MODIFY `usuario_acesso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;