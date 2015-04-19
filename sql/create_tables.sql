CREATE TABLE Asiakas(
	id SERIAL PRIMARY KEY NOT NULL,
	etunimi varchar(50) NOT NULL,
	sukunimi varchar(50) NOT NULL,
	puhelinnumero varchar(20) NOT NULL,
	email varchar(50),
	katuosoite varchar(50),
	postinumero varchar(5),
	postitoimipaikka varchar(50)
);

CREATE TABLE Kiinteisto(
	id SERIAL PRIMARY KEY NOT NULL,
	nimi varchar(50) NOT NULL,
	katuosoite varchar(50) NOT NULL,
	postinumero varchar(5) NOT NULL,
	postitoimipaikka varchar(50) NOT NULL
);

CREATE TABLE Autopaikka(
	id SERIAL PRIMARY KEY NOT NULL,
	kiinteisto_id INTEGER REFERENCES Kiinteisto(id),
	nimi varchar(10) NOT NULL,
	tyyppi INTEGER,
	sahkopistoke boolean DEFAULT FALSE
);

CREATE TABLE Varaus(
	id SERIAL PRIMARY KEY NOT NULL,
	autopaikka_id INTEGER REFERENCES Autopaikka(id),
	asiakas_id INTEGER REFERENCES Asiakas(id),
	aloitus_pvm DATE NOT NULL,
	paattymis_pvm DATE
);

CREATE TABLE Jonoentry(
	id SERIAL PRIMARY KEY NOT NULL,
	asiakas_id INTEGER REFERENCES Asiakas(id),
	kiinteisto_id INTEGER REFERENCES Kiinteisto(id),
	lisays_pvm DATE NOT NULL
);

CREATE TABLE Kayttaja(
	id SERIAL PRIMARY KEY NOT NULL,
	nimi varchar(50) NOT NULL,
	tunnus varchar(50) NOT NULL,
	salasana varchar(50) NOT NULL,
	paakaytto boolean DEFAULT FALSE
);