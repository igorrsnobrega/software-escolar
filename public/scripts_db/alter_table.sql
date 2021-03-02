ALTER TABLE cursos  ADD updated_at datetime DEFAULT current_timestamp();
ALTER TABLE cursos  ADD created_at datetime DEFAULT current_timestamp();

ALTER TABLE alunos  ADD updated_at datetime DEFAULT current_timestamp();
ALTER TABLE alunos  ADD created_at datetime DEFAULT current_timestamp();

ALTER TABLE startl26_startlive.modulos MODIFY COLUMN modulo_curso int(11) NULL;

ALTER TABLE modulos  ADD updated_at datetime DEFAULT current_timestamp();
ALTER TABLE modulos  ADD created_at datetime DEFAULT current_timestamp();

ALTER TABLE equipamentos  ADD updated_at datetime DEFAULT current_timestamp();
ALTER TABLE equipamentos   ADD created_at datetime DEFAULT current_timestamp();

ALTER TABLE alunos_cursos  ADD updated_at datetime DEFAULT current_timestamp();
ALTER TABLE alunos_cursos   ADD created_at datetime DEFAULT current_timestamp();

ALTER TABLE parametros_valor  ADD updated_at datetime DEFAULT current_timestamp();
ALTER TABLE parametros_valor  ADD created_at datetime DEFAULT current_timestamp();

ALTER TABLE contratos ADD updated_at datetime DEFAULT current_timestamp();
ALTER TABLE contratos ADD created_at datetime DEFAULT current_timestamp();

 ALTER TABLE startl26_startlive.parametros_valor MODIFY COLUMN pv_valor TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
 
 ALTER TABLE startl26_startlive.notas MODIFY COLUMN nota_observacao TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL NULL;