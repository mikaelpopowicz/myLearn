/**
*	Suppression des droits, de l'utilisateur et de la base si ils existent
*/
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'mika'@'localhost';
DROP USER 'mika'@'localhost';
DROP DATABASE IF EXISTS mika;

/**
*	Création de l'utilisateur, la base et affection des droits
*/
CREATE USER 'mika'@'localhost' IDENTIFIED BY  'mika';
CREATE DATABASE IF NOT EXISTS mika;
GRANT ALL PRIVILEGES ON  `mika` . * TO  'mika'@'localhost';
USE mika;


# -----------------------------------------------------------------------------
#       TABLE : matiere
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS matiere
 (
   id_m INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(128) NULL  ,
   icon VARCHAR(32) NULL
   , PRIMARY KEY (id_m) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : byte
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS byte
 (
   id_u INTEGER(2) NOT NULL AUTO_INCREMENT ,
   username VARCHAR(128) NULL  ,
   nom VARCHAR(128) NULL  ,
   prenom VARCHAR(128) NULL  ,
   email VARCHAR(128) NULL  ,
   password VARCHAR(40) NULL  ,
   salt VARCHAR(40)  ,
   token VARCHAR(40)  ,
   active BOOLEAN default 0 ,
   admin BOOLEAN default 0 ,
   dateByte DATETIME NULL
   , PRIMARY KEY (id_u) 
 ) 
 comment = "";

 # -----------------------------------------------------------------------------
 #       TABLE : session
 # -----------------------------------------------------------------------------

 CREATE TABLE IF NOT EXISTS session
  (
    id_s INTEGER(2) NOT NULL AUTO_INCREMENT ,
    id_u INTEGER(2) NULL  ,
	dateSession DATETIME NULL ,
    dateFin DATETIME NULL
    , PRIMARY KEY (id_s) 
  ) 
  comment = "";
  
# -----------------------------------------------------------------------------
#       TABLE : cours
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS cours
 (
   id_c INTEGER(2) NOT NULL AUTO_INCREMENT ,
   id_u INTEGER(2) NOT NULL  ,
   id_m INTEGER(2) NOT NULL  ,
   titre VARCHAR(128) NULL  ,
   description VARCHAR(128) NULL  ,
   contenu TEXT NULL  ,
   count_c INTEGER(4) DEFAULT 0 ,
   dateAjout DATETIME NULL  ,
   dateModif DATETIME NULL  
   , PRIMARY KEY (id_c) 
 ) 
 comment = "";
 
# -----------------------------------------------------------------------------
#       TABLE : archives
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS archives
 (
   id_a INTEGER(2) NOT NULL AUTO_INCREMENT ,
   id_c INTEGER(2) NOT NULL  ,
   titre VARCHAR(128) NULL  ,
   description VARCHAR(128) NULL  ,
   contenu TEXT NULL  ,
   dateModif DATETIME NULL  
   , PRIMARY KEY (id_a) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : comments
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS comments
 (
   id_q INTEGER(2) NOT NULL AUTO_INCREMENT ,
   id_c INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   dateCommentaire DATETIME NULL  ,
   commentaire VARCHAR(128) NULL  
   , PRIMARY KEY (id_q) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : acl
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS acl
 (
   id_m INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   insert_ BOOLEAN NULL  ,
   update_ BOOLEAN NULL  ,
   delete_ BOOLEAN NULL  
   , PRIMARY KEY (id_m,id_u) 
 ) 
 comment = "";


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_byte (id_u)
      REFERENCES byte (id_u) ON DELETE CASCADE;


ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_matiere (id_m)
      REFERENCES matiere (id_m) ;



ALTER TABLE comments
  ADD FOREIGN KEY FK_comments_cours (id_c)
      REFERENCES cours (id_c) ON DELETE CASCADE;


ALTER TABLE comments
  ADD FOREIGN KEY FK_comments_byte (id_u)
      REFERENCES byte (id_u) ON DELETE CASCADE;


ALTER TABLE acl 
  ADD FOREIGN KEY FK_acl_matiere (id_m)
      REFERENCES matiere (id_m) ;


ALTER TABLE acl 
  ADD FOREIGN KEY FK_acl_byte (id_u)
      REFERENCES byte (id_u) ;
  
INSERT INTO matiere VALUES ('', 'SLAM', 'fa fa-code'),
('', 'SISR', 'fa fa-terminal'),
('', 'MathÃ©matiques', 'fa fa-superscript'),
('', 'FranÃ§ais', 'fa fa-book'),
('', 'Algo', 'fa fa-gears'),
('', 'SI7', 'fa fa-sitemap'),
('', 'Economie', 'fa fa-eur'),
('', 'Droit', 'fa fa-gavel');

INSERT INTO byte VALUES (42, 'miko', 'Popowicz', 'Mikael', 'webmaster@iris-bde.fr', 'bbc1a65d97d8cbfc719d7e3a28ba8df244f60123', 'AZszBS8273dxz', sha1('coucoucoucou'), 1, 1, '2012-01-30 23:19:42');

INSERT INTO cours VALUES ('', 42, 1, 'La programmation orientÃ©e objet', 'L\'objet, une autre maniere de programmer', '<h2 class="short_headline">
	<span>Introduction</span>
</h2>
<h5 class="text-info">Année 70 <small>1972 -> C</small></h5>
<p>
	Dans la programmation structurée, un algo ou programme est constitué de deux parties :
	<ul>
		<li>
			Déclaration des objets de données
		</li>
		<li>
			Instructions ou actions qui s\'exercent sur ces objets
		</li>
	</ul>
</p>', 0, '2013-09-15 00:00:00', '2013-09-15 00:00:00'),
('', 42, 1, 'Algorithme simple', 'DÃ©couvrons la programmation', '<p class="text-info">Hey !</p>', 0, '2013-09-03 00:00:00', '2013-09-03 00:00:00'),
('', 42, 3, 'Les Ã©quations du second degrÃ©', 'C\'est fou les maths !', '<p class="text-info">Hoo !</p>', 0, '2013-09-26 00:00:00', '2013-09-26 00:00:00');

INSERT INTO comments VALUES ('', 1, 42, now(), "Super ce cours !!!!");

Delimiter @@

CREATE TRIGGER upCours
BEFORE UPDATE ON cours
FOR EACH ROW
BEGIN
INSERT INTO archives
VALUES ('', old.id_c, old.titre, old.description, old.contenu, old.dateModif);
END @@

Delimiter ;