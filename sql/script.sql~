--TABLA DEL INVESTIGADOR
CREATE TABLE researcher(
id_researcher serial not null primary key,
name varchar(50) not null,
surname varchar(50) not null,
email varchar(70) not null unique,
pass varchar(50) not null, --preguntar por algoritmo de encriptacion
username varchar(50) unique not null,
birthday date,
image varchar(10)
);


--PARAMETRIA DE RESULTADO DE TEST
CREATE TABLE result(
id_result serial not null,
type varchar(25)
);


--ENSAYO QUE REALIZA EL INVESTIGADOR
CREATE TABLE test(
id_test serial not null primary key,
test_name varchar(100),
test_date date not null,
test_description text,
id_result integer references result(id_result),
result_description text
);

--PLACA EN DONDE SE HACE EL ENSAYO
CREATE TABLE plaque(
id_plaque serial primary key not null,
id_test integer references test(id_test),
ordinal integer
);


