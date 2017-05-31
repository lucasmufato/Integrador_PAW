-- create database Inmunologia
-- create role paw password 'mufina';

--TABLA DEL INVESTIGADOR
CREATE TABLE researcher(
	id_researcher serial not null ,
	name varchar(50) not null,
	surname varchar(50) not null,
	email varchar(70) not null,
	pass varchar(50) not null, --preguntar por algoritmo de encriptacion
	username varchar(50) not null,
	birthday date,
	image varchar(10),

	CONSTRAINT researcher_pk PRIMARY KEY( id_researcher ),
	CONSTRAINT unique_mail UNIQUE(email),
	CONSTRAINT unique_username UNIQUE(username)
);


--PARAMETRIA DE RESULTADO DE TEST
CREATE TABLE result(
	id_result serial not null,
	tipo varchar(25), -- type no funcaba
	
	CONSTRAINT result_pk PRIMARY KEY( id_result )
);

CREATE TABLE status(
	id_status serial not null,
	tipo varchar(25),
	
	CONSTRAINT status_pk PRIMARY KEY( id_status )
);

--ENSAYO QUE REALIZA EL INVESTIGADOR
CREATE TABLE test(
	id_test serial not null,
	test_name varchar(100),
	test_date date not null,
	test_description text,
	id_result integer,
	result_description text,

	CONSTRAINT test_pk PRIMARY KEY(id_test),
	CONSTRAINT fk_test__result FOREIGN KEY (id_result) REFERENCES result (id_result)
);

--PLACA EN DONDE SE HACE EL ENSAYO
CREATE TABLE plaque(
	id_plaque serial not null,
	id_test integer,
	ordinal integer,

	CONSTRAINT plaque_pk PRIMARY KEY(id_plaque),
	CONSTRAINT fk_plaque__test FOREIGN KEY (id_test) REFERENCES test (id_test)
);



--PASO QUE SE EJECUTARA EN LA PLACA
CREATE TABLE step(
	id_step serial not null,
	description text not null,
	id_status integer not null,

	CONSTRAINT step_pk PRIMARY KEY(id_step),
	CONSTRAINT fk_step__status FOREIGN KEY (id_status) REFERENCES status(id_status)
);

CREATE TABLE step_plaque(
	id_plaque integer not null,
	id_step integer not null, 
	ordina integer not null,

	CONSTRAINT step_plaque_pk PRIMARY KEY(id_plaque,id_step),
	CONSTRAINT fk_step_plaque__plaque FOREIGN KEY (id_plaque) REFERENCES plaque(id_plaque),
	CONSTRAINT fk_step_plaque__step FOREIGN KEY (id_step) REFERENCES step(id_step)
);

CREATE TABLE well(
	id_well serial not null,
	fila integer not null,
	columna char not null,

	CONSTRAINT well_pk PRIMARY KEY(id_well),
	CONSTRAINT unique_well UNIQUE(fila,columna)
);

CREATE TABLE step_in_plaque_well(
	id_step integer not null,
	id_plaque integer not null,
	id_well integer not null,
	id_status integer not null, 
	quantity real,

	CONSTRAINT step_in_plaque_well_pk PRIMARY KEY(id_plaque,id_step,id_well),
	CONSTRAINT fk_step_in_plaque_well__step FOREIGN KEY (id_step) REFERENCES step(id_step),
	CONSTRAINT fk_step_in_plaque_well__plaque FOREIGN KEY (id_plaque) REFERENCES plaque(id_plaque),
	CONSTRAINT fk_step_in_plaque_well__well FOREIGN KEY (id_well) REFERENCES well(id_well),
	CONSTRAINT fk_step_in_plaque_well__status FOREIGN KEY (id_status) REFERENCES status(id_status)

);

CREATE TABLE plaque_well(
	id_plaque integer not null,
	id_well integer not null,

	CONSTRAINT plaque_well_pk PRIMARY KEY(id_plaque,id_well),
	CONSTRAINT fk_plaque_well__plaque FOREIGN KEY (id_plaque) REFERENCES plaque(id_plaque),
	CONSTRAINT fk_plaque_well__well FOREIGN KEY (id_well) REFERENCES well(id_well)
);

CREATE TABLE step_type_plaque(
	id_step integer not null,
	clock time,

	CONSTRAINT step_type_plaque_pk PRIMARY KEY(id_step),
	CONSTRAINT fk_step_tyep_plaque__step FOREIGN KEY (id_step) REFERENCES step(id_step)
);

/*   ESTA TABLA?

CREATE TABLE step_type_well(
	id_step references step(id_step)
);
*/
