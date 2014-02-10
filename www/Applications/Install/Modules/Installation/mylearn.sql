# -----------------------------------------------------------------------------
#       TABLE : devoir
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS devoir
 (
   id_d INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL  ,
   dateDevoir DATE NULL  ,
   enonce VARCHAR(128) NULL  ,
   dateMax DATE NULL  
   , PRIMARY KEY (id_d) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : user
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS user
 (
   id_u INTEGER(2) NOT NULL  ,
   username VARCHAR(128) NULL  ,
   nom VARCHAR(128) NULL  ,
   prenom VARCHAR(128) NULL  ,
   email VARCHAR(128) NULL  ,
   password VARCHAR(128) NULL  ,
   active BOOL NULL  ,
   salt VARCHAR(40) NULL  ,
   token VARCHAR(40) NULL ,
   dateUser DATE
   , PRIMARY KEY (id_u) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : administrateur
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS administrateur
 (
   id_u INTEGER(2) NOT NULL  ,
   poste VARCHAR(80)
   , PRIMARY KEY (id_u) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : matiere
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS matiere
 (
   id_m INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(128) NULL  ,
   icon VARCHAR(32)
   , PRIMARY KEY (id_m) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : professeur
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS professeur
 (
   id_u INTEGER(2) NOT NULL  ,
   id_m INTEGER(2) NOT NULL
   , PRIMARY KEY (id_u) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : eleve
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS eleve
 (
   id_u INTEGER(2) NOT NULL  ,
   dateNaissance DATE NOT NULL
   , PRIMARY KEY (id_u) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : etre
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS etre
 (
   id_u INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL
   , PRIMARY KEY (id_u,id_classe) 
 ) 
comment = "";
# -----------------------------------------------------------------------------
#       TABLE : session
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS session
 (
   session VARCHAR(128) NOT NULL  
   , PRIMARY KEY (session) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : section
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS section
 (
   id_section INTEGER(2) NOT NULL AUTO_INCREMENT ,
   id_u INTEGER(2) NOT NULL  ,
   libelle VARCHAR(128) NOT NULL  
   , PRIMARY KEY (id_section) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : gestionnaire
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS gestionnaire
 (
   id_u INTEGER(2) NOT NULL
   , PRIMARY KEY (id_u) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : gerer
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS gerer
 (
   id_u INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL
   , PRIMARY KEY (id_u) 
 ) 
comment = "";
# -----------------------------------------------------------------------------
#       TABLE : classe
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS classe
 (
   id_classe INTEGER(2) NOT NULL AUTO_INCREMENT ,
   session VARCHAR(128) NOT NULL  ,
   id_section INTEGER(2) NOT NULL  ,
   libelle VARCHAR(128) NOT NULL  
   , PRIMARY KEY (id_classe) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : cours
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cours
 (
   id_cours INTEGER(2) NOT NULL  ,
   id_m INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   titre VARCHAR(128) NULL  ,
   description VARCHAR(128) NULL  ,
   contenu TEXT NULL  ,
   dateAjout DATETIME NULL  ,
   dateModif DATETIME NULL  
   , PRIMARY KEY (id_cours) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : vers_cours
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS vers_cours
 (
   id_cours INTEGER(2) NOT NULL  ,
   titre VARCHAR(128) NULL  ,
   description VARCHAR(128) NULL  ,
   contenu TEXT NULL  ,
   dateModif DATETIME NULL  
   , PRIMARY KEY (id_cours,dateModif) 
 ) 
comment = "";
# -----------------------------------------------------------------------------
#       TABLE : histo_cours
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS histo_cours
 (
   id_cours INTEGER(2) NOT NULL  ,
   id_m INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   titre VARCHAR(128) NULL  ,
   description VARCHAR(128) NULL  ,
   contenu TEXT NULL  ,
   dateAjout DATETIME NULL  ,
   dateModif DATETIME NULL  ,
   dateHisto DATETIME NULL
   , PRIMARY KEY (id_cours) 
 ) 
comment = "";
# -----------------------------------------------------------------------------
#       TABLE : assigner
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS assigner
 (
   id_m INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL  
   , PRIMARY KEY (id_m,id_classe) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : commenter
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS commenter
 (
   id_u INTEGER(2) NOT NULL  ,
   id_cours INTEGER(2) NOT NULL  ,
   dateCommentaire DATETIME NOT NULL  ,
   commentaire TEXT NOT NULL  
   , PRIMARY KEY (id_u,id_cours,dateCommentaire) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : avoir
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS avoir
 (
   id_d INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   dateRendu DATE NULL  ,
   note DECIMAL(10,2) NULL  
   , PRIMARY KEY (id_d,id_u) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------
ALTER TABLE devoir 
  ADD FOREIGN KEY FK_devoir_professeur (id_u)
      REFERENCES professeur (id_u) ;
ALTER TABLE devoir 
  ADD FOREIGN KEY FK_devoir_classe (id_classe)
      REFERENCES classe (id_classe) ;
ALTER TABLE administrateur 
  ADD FOREIGN KEY FK_administrateur_user (id_u)
      REFERENCES user (id_u) ;
ALTER TABLE professeur 
  ADD FOREIGN KEY FK_professeur_matiere (id_m)
      REFERENCES matiere (id_m) ;
ALTER TABLE professeur 
  ADD FOREIGN KEY FK_professeur_user (id_u)
      REFERENCES user (id_u) ;
ALTER TABLE eleve 
  ADD FOREIGN KEY FK_eleve_user (id_u)
      REFERENCES user (id_u) ;
ALTER TABLE etre 
 ADD FOREIGN KEY FK_etre_eleve (id_u)
     REFERENCES eleve (id_u) ;
ALTER TABLE etre 
ADD FOREIGN KEY FK_etre_classe (id_classe)
    REFERENCES classe (id_classe) ;
ALTER TABLE section 
  ADD FOREIGN KEY FK_section_administrateur (id_u)
      REFERENCES administrateur (id_u) ;
ALTER TABLE gestionnaire 
  ADD FOREIGN KEY FK_gestionnaire_user (id_u)
      REFERENCES user (id_u) ;
ALTER TABLE gerer 
  ADD FOREIGN KEY FK_gerer_gestionnaire (id_u)
      REFERENCES gestionnaire (id_u) ;
ALTER TABLE gerer 
  ADD FOREIGN KEY FK_gerer_classe (id_classe)
      REFERENCES classe (id_classe) ;
ALTER TABLE classe 
  ADD FOREIGN KEY FK_classe_session (session)
      REFERENCES session (session) ;
ALTER TABLE classe 
  ADD FOREIGN KEY FK_classe_section (id_section)
      REFERENCES section (id_section) ;
ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_matiere (id_m)
      REFERENCES matiere (id_m) ;
ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_classe (id_classe)
      REFERENCES classe (id_classe) ;
ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_user (id_u)
      REFERENCES user (id_u) ;
ALTER TABLE vers_cours 
   ADD FOREIGN KEY FK_vers_cours_cours (id_cours)
       REFERENCES cours (id_cours) ;
ALTER TABLE assigner 
  ADD FOREIGN KEY FK_assigner_matiere (id_m)
      REFERENCES matiere (id_m) ;
ALTER TABLE assigner 
  ADD FOREIGN KEY FK_assigner_classe (id_classe)
      REFERENCES classe (id_classe) ;
ALTER TABLE commenter 
  ADD FOREIGN KEY FK_commenter_user (id_u)
      REFERENCES user (id_u) ;
ALTER TABLE commenter 
  ADD FOREIGN KEY FK_commenter_cours (id_cours)
      REFERENCES cours (id_cours) ;
ALTER TABLE avoir 
  ADD FOREIGN KEY FK_avoir_devoir (id_d)
      REFERENCES devoir (id_d) ;
ALTER TABLE avoir 
  ADD FOREIGN KEY FK_avoir_eleve (id_u)
      REFERENCES eleve (id_u) ;
# -----------------------------------------------------------------------------
#       CREATION TRIGGERS ET PROCEDURES
# -----------------------------------------------------------------------------
Delimiter @@
/*
*	Procédure d'archivage de cours d'une session
*/
CREATE PROCEDURE archiver_cours(sess VARCHAR(128))
BEGIN
Declare fini int default 0;
Declare cours, matiere, classe, user INTEGER(2);
Declare titre, description VARCHAR(128);
Declare contenu TEXT;
Declare dateAjout, dateModif DATETIME;
Declare curc CURSOR
	FOR SELECT co.id_cours, co.id_m, co.id_classe, co.id_u, co.titre, co.description, co.contenu, co.dateAjout, co.dateModif
		FROM cours co
		INNER JOIN classe cl ON co.id_classe = cl.id_classe
		INNER JOIN session s ON cl.session = s.session
		WHERE s.session = sess;
Declare continue HANDLER
	FOR NOT FOUND SET fini = 1;
Open curc;
FETCH curc INTO cours, matiere, classe, user, titre, description, contenu, dateAjout, dateModif;

While fini != 1
	DO
	INSERT INTO histo_cours VALUES(cours, matiere, classe, user, titre, description, contenu, dateAjout, dateModif, sysdate());
	DELETE FROM vers_cours WHERE id_cours = cours;
	DELETE FROM cours WHERE id_cours = cours;
	FETCH curc INTO cours, matiere, classe, user, titre, contenu, description, dateAjout, dateModif;
END While;
Close curc;
END @@

/*
*	Trigger versioning cours
*/
CREATE TRIGGER version_cours
BEFORE UPDATE ON cours
FOR EACH ROW
BEGIN
	# Compter le nombre de versions existantes
	Declare versions int;
	SELECT COUNT(*) INTO versions
	FROM vers_cours
	WHERE id_cours = new.id_cours;
	# Suppression de la plus vielle version si il y en déjà 5
	IF versions > 4
	THEN
		# /!\ ATTENTION /!\ pour trouver le dateModif le plus petit, il faut utiliser une sous-requête avec un alias, car l'on cherche dans la table ou l'on veut supprimer cela bloque la table en question !!
		DELETE FROM vers_cours
		WHERE id_cours = new.id_cours
		AND dateModif in (
			SELECT * FROM (
				SELECT MIN(dateModif)
				FROM vers_cours
				WHERE id_cours = new.id_cours
			) AS t
		);
	END IF;
	INSERT INTO vers_cours VALUES(new.id_cours,old.titre,old.description,old.contenu,sysdate());
	SET new.dateModif = sysdate();
END @@
/*
*	Procédure de restauration d'une version de cours
*/
CREATE PROCEDURE restaurer_cours(id int, version DATETIME)
BEGIN
	# Déclaration
	Declare v_titre, v_desc VARCHAR(128);
	Declare v_contenu TEXT;
	# Récupération du titre, description et contenu de la version choisie
	SELECT titre, description, contenu INTO v_titre, v_desc, v_contenu
	FROM vers_cours 
	WHERE id_cours=id
	AND dateModif=version;
	# Insertion des informations récupérés dans le cours choisi
	UPDATE cours 
	SET titre = v_titre, 
	description = v_desc,
	contenu = v_contenu
	WHERE id_cours=id;
END @@
/*
*	Fonction gérant l'auto-incrément
*/
Create function autoincrement()
returns INTEGER(2)
	Deterministic
Begin
	Declare nbi int;
	SELECT MAX(id_u) INTO nbi
	FROM user;
	IF nbi IS NULL
	THEN
		SET nbi = 0;
	END IF;
	SET nbi = nbi+1;
	return nbi;
END @@
/*
*	Enregistrement d'un élève
*/
CREATE PROCEDURE ajouter_eleve(a_username VARCHAR(128), a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), a_salt VARCHAR(40), a_token VARCHAR(40), a_dateNaissance DATE)
BEGIN
	# Récupération du nouvel id
	Declare id int;
	SET id = (SELECT autoincrement());
	
	# Vérifions que l'admin n'est pas bête au point de faire des doublons
	IF (SELECT COUNT(*) FROM user u INNER JOIN eleve e ON u.id_u = e.id_u WHERE u.nom = a_nom AND u.prenom = a_prenom AND e.dateNaissance = a_dateNaissance) < 1
	THEN
		# Insertion de l'élève dans la table USER
		INSERT INTO user VALUES(id, a_username, a_nom, a_prenom, a_email, a_pass, 0, a_salt, a_token, CURDATE());
		INSERT INTO eleve VALUES(id, a_dateNaissance);
	END IF;
END @@
/*
*	Créer un élève gestionnaire
*/
CREATE PROCEDURE ajouter_gest(id INTEGER(2))
BEGIN
	# Vérifier qu'il s'agit d'un élève
	# Vérifions que l'admin n'est pas bête au point de faire des doublons
	IF (SELECT COUNT(*) FROM user u INNER JOIN eleve e ON e.id_u = u.id_u WHERE u.nom = a_nom AND u.prenom = a_prenom AND e.dateNaissance = a_dateNaissance) < 1
	THEN
		# Insertion de l'élève dans la table USER
		INSERT INTO user VALUES(id, a_username, a_nom, a_prenom, a_email, a_pass, 0, a_salt, a_token, CURDATE());
		INSERT INTO eleve VALUES(id, a_dateNaissance);
	END IF;

END @@
/*
*	Enregistrement d'un professeur
*/
CREATE PROCEDURE ajouter_prof(a_username VARCHAR(128), a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), a_salt VARCHAR(40), a_token VARCHAR(40), matiere INTEGER(2))
BEGIN
	# Récupération du nouvel id
	Declare id int;
	SET id = (SELECT autoincrement());
	# Vérifions que l'admin n'est pas bête au point de faire des doublons
	IF (SELECT COUNT(*) FROM user u INNER JOIN professeur p ON p.id_u = u.id_u WHERE u.nom = a_nom AND u.prenom = a_prenom AND p.id_m = matiere) < 1
	THEN
		# Insertion du professeur dans la table USER
		INSERT INTO user VALUES(id, a_username, a_nom, a_prenom, a_email, a_pass, 0, a_salt, a_token, CURDATE());
		INSERT INTO professeur VALUES(id, matiere);
	END IF;
END @@
/*
*	Enregistrement d'un administrateur
*/
CREATE PROCEDURE ajouter_admin(a_username VARCHAR(128), a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), a_salt VARCHAR(40), a_token VARCHAR(40), a_poste VARCHAR(80))
BEGIN
	# Récupération du nouvel id
	Declare id int;
	SET id = (SELECT autoincrement());
	# Vérifions que l'admin n'est pas bête au point de faire des doublons
	IF (SELECT COUNT(*) FROM user u INNER JOIN administrateur a ON a.id_u = u.id_u WHERE u.nom = a_nom AND u.prenom = a_prenom AND a.poste = a_poste) < 1
	THEN
		# Insertion du professeur dans la table USER
		INSERT INTO user VALUES(id, a_username, a_nom, a_prenom, a_email, a_pass, 1, a_salt, a_token, CURDATE());
		INSERT INTO administrateur VALUES(id, a_poste);
	END IF;
END @@
/*
*	Recherche de la session en cours
*/
CREATE FUNCTION trouver_session()
returns VARCHAR(10)
	Deterministic
Begin
	Declare sess VARCHAR(10);
	IF MONTH(CURDATE()) < 8
	THEN
		SELECT session INTO sess
		FROM session
		WHERE session like CONCAT("%/",YEAR(CURDATE()));
	ELSE
		SELECT session INTO sess
		FROM session
		WHERE session like CONCAT(YEAR(CURDATE()),"/%");
	END IF;
	IF sess IS NULL
	THEN
		SET sess = "NOT FOUND";
	END IF;
	return sess;
END @@
/*
*	Enregistrement d'une session
*/
CREATE PROCEDURE ajouter_session(sess VARCHAR(10))
BEGIN
	Declare message VARCHAR(10);
	IF sess = "FIRST"
	THEN
		IF MONTH(CURDATE()) < 7
		THEN
			INSERT INTO session VALUES(CONCAT(YEAR(CURDATE())-1,'/',YEAR(CURDATE())));
		ELSE
			INSERT INTO session VALUES(CONCAT(YEAR(CURDATE()),"/",YEAR(CURDATE())+1));
		END IF;
	ELSE
		INSERT INTO session VALUES(sess);
		SELECT session INTO message
		FROM session
		WHERE session like CONCAT("%/",SUBSTR(sess,1,4));
		IF message IS NOT NULL
		THEN
			CALL auto_class(message, sess);
		END IF;
	END IF;
END @@
/*
*	Création automatique des classes d'une nouvelle session en fonction d'une autre
*/
CREATE PROCEDURE auto_class(prev VARCHAR(128), next VARCHAR(128))
BEGIN
Declare fini int default 0;
Declare c_section INTEGER(2);
Declare c_libelle VARCHAR(128); 
Declare curc CURSOR
	FOR SELECT id_section, libelle
		FROM classe c
		INNER JOIN session s ON c.session = s.session
		WHERE s.session like prev;
Declare continue HANDLER
	FOR NOT FOUND SET fini = 1;
Open curc;
FETCH curc INTO c_section, c_libelle;
While fini != 1
	DO
	INSERT INTO classe VALUES("", next, c_section, c_libelle);
	FETCH curc INTO c_section, c_libelle;
END While;
Close curc;
END @@
Delimiter ;
# -----------------------------------------------------------------------------
#       CREATION COMPTE ADMIN, PROF, ELEVE
# -----------------------------------------------------------------------------
CALL ajouter_admin("admin", "admin", "admin", "admin@domain.tld","7a53be99a2d39e90884249a0260f753e24033947", "8262216f0c53cd1ebc83e1bb6b84ddce84fe7738", sha1(md5('tokenadministrateur')), "superAdmin");