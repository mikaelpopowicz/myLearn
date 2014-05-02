# Question 2

CREATE VIEW FORMATIONS_RECENTES AS
SELECT num_formation, date_formation, domaine_formation
FROM FORMATION
WHERE YEAR(date_formation) = "2013";

# Question 3

INSERT INTO EQUIPEMENT VALUES (1251, "HP LaserJet Professional P1102w", "Imprimante", 101);

# Question 4

CREATE TABLE STATIONS_DE_TRAVAIL AS
SELECT num_equipement, nom_equipement
FROM EQUIPEMENT
WHERE type_equipement LIKE "STATION_DE_TRAVAIL";

# Question 5

#1
SELECT d.numDep, d.nomDep
FROM DEPARTEMENT d
INNER JOIN SIEGE_SOCIAL s ON s.num_site = d.num_site;
#2
SELECT numOrg, adresseOrg, raison_sociale
FROM ENTREPRISE
WHERE taille_entreprise LIKE "GRANDE";
#3
SELECT COUNT(*)
FROM FILILALE_OP
GROUP BY pays_site;
#4
SELECT COUNT(s.num_service)
FROM SERVICE_OP s
INNER JOIN FILILALE_OP f ON f.numSite = s.numSite
WHERE s.nomSite LIKE "Filiale_de_Grenoble";
#5
SELECT nom_filiale_operationnelle
FROM FILIALE_OP
WHERE numSite NOT IN (
	SELECT f.numSite
	FROM FILIALE_OP f
	INNER JOIN FORMATION fr ON fr.numSite = f.numSite
);
#6
SELECT *
FROM FILIALE_OP
WHERE numSite IN (
	SELECT numSite
	FROM FILIALE_OP f
	INNER JOIN FORMATION_L fl ON fl.numSite = f.numSite
	WHERE YEAR(fl.date_formation) = "2013"
);
#7
SELECT o.num_organisme, COUNT(fc.numFormation) AS 'Nombre'
FROM ORGANISME o
INNER JOIN FORMATION_C fc ON fc.num_organisme = o.num_organisme
WHERE YEAR(fc.date_formation) = "2012"
GROUP BY o.numOrg
HAVING 'Nombre' > 3;
#8
SELECT u.num_organisme, u.nom_université
FROM UNIVERSITE u
INNER JOIN FORMATION fo ON fo.num_organisme = u.num_organisme
INNER JOIN FILIALE_OP f ON fo.numSite = f.numSite
WHERE f.nom_site LIKE "Filiale de Lille";
