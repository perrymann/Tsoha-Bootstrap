INSERT INTO Asiakas (etunimi, sukunimi, katuosoite, postinumero, postitoimipaikka, puhelinnumero, email) 
VALUES ('Stig', 'Testimies','Testikatu 4', '00666', 'Testilä', '88946489648', 'stigu@ghdjdjd.com');

INSERT INTO Asiakas (etunimi, sukunimi, katuosoite, postinumero, postitoimipaikka, puhelinnumero, email) 
VALUES ('Pekka', 'Pekkanen','Testikatu 8', '00666', 'Testilä', '8894645332', 'peku@ghdjdjd.com');

INSERT INTO Kiinteisto (nimi, katuosoite, postinumero, postitoimipaikka) 
VALUES ('As Oy Testikatu 4','Testikatu 4', '00666', 'Testilä');
 
INSERT INTO Kiinteisto (nimi, katuosoite, postinumero, postitoimipaikka) 
VALUES ('As Oy Testikatu 10', 'Testikatu 10', '00666', 'Testilä');

INSERT INTO Autopaikka (kiinteisto_id, nimi, tyyppi, sahkopistoke)
VALUES ('1', '13', '1', true);

INSERT INTO Autopaikka (kiinteisto_id, nimi, tyyppi, sahkopistoke)
VALUES ('1', '14', '1', true);

INSERT INTO Varaus (autopaikka_id, asiakas_id, aloitus_pvm, paattymis_pvm)
VALUES ('1', '13', '2015-04-16', );

INSERT INTO Kayttaja (nimi, tunnus, salasana, paakaytto)
VALUES ('K. Kayttaja', 'koekayttaja', 'koekayttaja', false);
