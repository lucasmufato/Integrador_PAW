GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO lucria;
ALTER ROLE lucria WITH login;

INSERT INTO status(id_status, tipo) VALUES (1, 'Finalizado');
INSERT INTO status(id_status, tipo) VALUES (2, 'En Proceso');
INSERT INTO status(id_status, tipo) VALUES (3, 'Iniciado');
INSERT INTO status(id_status, tipo) VALUES (4, 'SinIniciar');

INSERT INTO researcher(name, surname, email, pass, username, birthday, image)
    VALUES ('lucas', 'mufato', 'l.mufato@gmail.com', 'mufina', 'lucaster', current_date, null);

-- apenas creado el test y mientras se definen los pasos y eso
INSERT INTO result(tipo) VALUES ('creando');

-- si no inicia el test de inmediato queda en este estado
INSERT INTO result(tipo) VALUES ('no iniciado');

-- mientras realiza el test
INSERT INTO result(tipo) VALUES ('en trabajo');

-- estado en el q queda cuando es finalizado
INSERT INTO result(tipo) VALUES ('exitoso');
INSERT INTO result(tipo) VALUES ('fallido');
INSERT INTO result(tipo) VALUES ('descartado');

