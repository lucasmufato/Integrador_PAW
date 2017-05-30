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



--PASO QUE SE EJECUTARA EN LA PLACA
CREATE TABLE step(
id_step serial not null primary key,
description text not null,
id_status not null references status(id_status)
);

CREATE TABLE step_plaque(
id_plaque primary key not null references plaque(id_plaque),
id_step primary key not null references step(id_step),
ordina integer not null
);

CREATE TABLE well(
id_well serial not null primary key,
row integer not null unique,
column char not null unique
);

CREATE TABLE step_in_plaque_well(
id_step primary key not null references step(id_step),
id_plaque primary key not null references plaque(id_plaque),
id_well primary key not null references well(id_well),
id_status not null references status(id_status),
quantity real
);

CREATE TABLE plaque_well(
	id_plaque not null primary key references plaque(id_plaque),
	id_well not null primary key references well(id_well)
);

CREATE TABLE step_type_plaque(
	id_step primary key not null references step(id_step),
	clock time
);

CREATE TABLE step_type_well(
	id_step references step(id_step)
);
