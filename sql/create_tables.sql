CREATE TABLE Asiakas(
	id SERIAL PRIMARY KEY NOT NULL,
	katuosoite varchar(50),
	postinumero varchar(5),
	postitoimipaikka varchar(50),
	puhelinnumero varchar(20) NOT NULL,
	puhelinnumero2 varchar(20),
	email varchar(50)
);

CREATE TABLE Luonnollinen_hlo(
	etunimi varchar(50) NOT NULL,
	sukunimi varchar(50) NOT NULL,
) INHERITS (Asiakas);

CREATE TABLE Oikeushlo(
	nimi varchar(50) NOT NULL,
	yhteyshlo varchar(50)
) INHERITS (Asiakas);

CREATE TABLE Kiinteisto(
	id SERIAL PRIMARY KEY NOT NULL,
	nimi varchar(50) NOT NULL,
	katuosoite varchar(50) NOT NULL,
	postinumero varchar(5), NOT NULL,
	postitoimipaikka varchar(50) NOT NULL
);

CREATE TABLE Ap_alue(
	id SERIAL PRIMARY KEY NOT NULL,
	nimi varchar(20) NOT NULL
);	

CREATE TABLE Autopaikka(
	id 	SERIAL PRIMARY KEY NOT NULL,
	Ap_alue_id integer REFERENCES Ap_alue(id),
	nimi varchar(10) NOT NULL,
	tyyppi	integer,
	sahkopistoke boolean DEFAULT FALSE
);

CREATE TABLE Varaus(
	id SERIAL PRIMARY KEY NOT NULL,
	Autopaikka_id integer REFERENCES Autopaikka(id),
	Asiakas_id integer REFERENCES Asiakas(id),
	aloitus_pvm date NOT NULL,
	paattymis_pvm date,
	varaus_pvm date NOT NULL,
	irtisanomis_pvm date,
);

CREATE TABLE Jonoentry(
	id SERIAL PRIMARY KEY NOT NULL,
	Asiakas_id integer REFERENCES Asiakas(id),
	Ap_alue_id integer REFERENCES Ap_alue(id)
);

CREATE TABLE Linkitys( -- linkittää kiinteistön ja autopaikka-alueen
	id SERIAL PRIMARY KEY NOT NULL,
	Ap_alue_id integer REFERENCES Ap_alue(id),
	Kiinteisto_id integer REFERENCES Kiinteisto(id)
);

CREATE TABLE Kayttaja(
	id SERIAL PRIMARY KEY NOT NULL,
	nimi varchar(50) NOT NULL,
	tunnus varchar(50) NOT NULL,
	salasana varchar(50) NOT NULL
	paakaytto boolean DEFAULT FALSE
);