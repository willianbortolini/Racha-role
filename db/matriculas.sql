CREATE TABLE matriculas (
    matriculas_id INT AUTO_INCREMENT PRIMARY KEY,
    usuarios_id INT NOT NULL,
    cursos_id INT NOT NULL,
    recebimentos_id INT NOT NULL,
    data_da_matricula DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id),
    FOREIGN KEY (cursos_id) REFERENCES cursos(cursos_id),
    FOREIGN KEY (recebimentos_id) REFERENCES recebimentos(recebimentos_id)
);
