CREATE TABLE parcelas(
	parcela_id int PRIMARY KEY auto_increment,
	contrato_id int NOT NULL,
	num_parcela int NOT NULL,
	valor_parcela decimal(10,2) NOT NULL,
	status_pagamento int NOT NULL,
	data_pagamento datetime,	
	created_at datetime DEFAULT current_timeStamp(),
	updated_at datetime DEFAULT current_timeStamp()
);


ALTER  TABLE parcelas ADD FOREIGN KEY (contrato_id) REFERENCES contratos (cont_id);