GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO lucira;

INSERT INTO status(id_status, tipo) VALUES (1, 'Finalizado');
INSERT INTO status(id_status, tipo) VALUES (2, 'En Proceso');
INSERT INTO status(id_status, tipo) VALUES (3, 'Iniciado');
-- TODO: HACER INSERT INTO CON UN INVESTIGADOR PARA REALIZAR PRUEBAS

INSERT INTO researcher(name, surname, email, pass, username, birthday, image)
    VALUES ('lucas', 'mufato', 'l.mufato@gmail.com', 'mufina', 'lucaster', current_date, null);