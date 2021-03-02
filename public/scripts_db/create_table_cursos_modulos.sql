CREATE TABLE cursos_modulos(
	controle_id int PRIMARY KEY auto_increment,
	curso_id int NOT NULL,
	modulo_id int NOT NULL,
	created_at datetime DEFAULT current_timeStamp(),
	updated_at datetime DEFAULT current_timeStamp()
);

ALTER TABLE cursos_modulos ADD FOREIGN KEY (curso_id) REFERENCES cursos (curso_id);
ALTER TABLE cursos_modulos ADD FOREIGN KEY (modulo_id) REFERENCES modulos (modulo_id);