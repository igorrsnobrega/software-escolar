INSERT INTO cursos_modulos (curso_id, modulo_id) SELECT m.modulo_curso 
                                                      , m.modulo_id 
                                                   FROM modulos m
                                                  WHERE m.modulo_curso IS NOT null;

ALTER TABLE modulos DROP COLUMN modulo_curso;