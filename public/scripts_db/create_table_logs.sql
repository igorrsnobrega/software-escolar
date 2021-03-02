-- registra log
CREATE TABLE logs(
	log_id int PRIMARY KEY AUTO_INCREMENT,
	modulo varchar(191) NOT NULL,
	antes text NOT NULL,
	depois text NOT NULL,
	created_at datetime DEFAULT current_timeStamp(),
	updated_at datetime DEFAULT current_timeStamp()
);