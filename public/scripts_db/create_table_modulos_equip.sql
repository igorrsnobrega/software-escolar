CREATE TABLE modulos_equip(
	controle_id int PRIMARY KEY auto_increment,
	equip_id int NOT NULL,
	modulo_id int NOT NULL,
	created_at datetime DEFAULT current_timeStamp(),
	updated_at datetime DEFAULT current_timeStamp()
);

ALTER TABLE modulos_equip ADD FOREIGN KEY (equip_id) REFERENCES equipamentos (equip_id);
ALTER TABLE modulos_equip ADD FOREIGN KEY (modulo_id) REFERENCES modulos (modulo_id);