# -----------------------------------------------------------------------------
#       TABLE : devoir
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS devoir
 (
   id_d INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL  ,
   dateDevoir DATE NULL  ,
   libelle VARCHAR(1024) NOT NULL ,
   enonce VARCHAR(128) NULL  ,
   active BOOLEAN NOT NULL DEFAULT false ,
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
#       TABLE : crypt
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS crypt
 (
   token VARCHAR(40) NOT NULL  ,
   message VARCHAR(1024) NULL  ,
   cle VARCHAR(32) NULL  ,
   PRIMARY KEY (token)
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
   uri VARCHAR(128) NULL  ,
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
#       TABLE : charger
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS charger
 (
   id_classe INTEGER NOT NULL  ,
   id_u INTEGER NOT NULL  ,
   PRIMARY KEY (id_classe,id_u)
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
   id_session INTEGER NOT NULL AUTO_INCREMENT  ,
   session VARCHAR(128) NOT NULL  
   , PRIMARY KEY (id_session) 
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
#       TABLE : classe
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS classe
 (
   id_classe INTEGER(2) NOT NULL AUTO_INCREMENT ,
   id_session INTEGER NOT NULL  ,
   id_section INTEGER(2) NOT NULL  ,
   libelle VARCHAR(128) NOT NULL  ,
   uri VARCHAR(128) NOT NULL  
   , PRIMARY KEY (id_classe) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : cours
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cours
 (
   id_cours INTEGER(2) NOT NULL ,
   id_m INTEGER(2) NOT NULL  ,
   id_classe INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   titre VARCHAR(1024) NULL  ,
   uri VARCHAR(1024) NULL  ,
   description TEXT NULL  ,
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
   titre VARCHAR(1024) NULL  ,
   uri VARCHAR(1024) NULL  ,
   description TEXT NULL  ,
   contenu TEXT NULL  ,
   dateModif DATETIME NULL  
   , PRIMARY KEY (id_cours,dateModif) 
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
#       TABLE : vue
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS vue
 (
   id_v INTEGER NOT NULL AUTO_INCREMENT  ,
   id_u INTEGER(2) NOT NULL  ,
   id_cours INTEGER(2) NOT NULL  ,
   dateVue DATETIME  
   , PRIMARY KEY (id_v) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : commenter
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS commenter
 (
   id_com INTEGER NOT NULL AUTO_INCREMENT  ,
   id_u INTEGER(2) NOT NULL  ,
   id_cours INTEGER(2) NOT NULL  ,
   dateCommentaire DATETIME NOT NULL  ,
   commentaire TEXT NOT NULL  
   , PRIMARY KEY (id_com) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : avoir
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS avoir
 (
   id_d INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL  ,
   commentaire TEXT NULL  ,
   note DECIMAL(10,2) NULL  
   , PRIMARY KEY (id_d,id_u) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : piece_jointe
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS piece_jointe
 (
   id_pj INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(512) NOT NULL  ,
   chemin VARCHAR(512) NOT NULL  ,
   dateUpload DATETIME NULL  ,
   id_d INTEGER(2) NOT NULL
   , PRIMARY KEY (id_pj) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : piece_rendu
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS piece_rendu
 (
   id_pr INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(512) NOT NULL  ,
   chemin VARCHAR(512) NOT NULL  ,
   dateUpload DATETIME NULL  ,
   id_d INTEGER(2) NOT NULL  ,
   id_u INTEGER(2) NOT NULL
   , PRIMARY KEY (id_pr) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       TABLE : errors
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS errors
 (
   code VARCHAR(10) NOT NULL  ,
   message VARCHAR(128) NOT NULL  ,
   type VARCHAR(10) NOT NULL
   , PRIMARY KEY (code) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : logs_con
# -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS logs_con
 (
   id_con INTEGER(2) NOT NULL AUTO_INCREMENT ,
   id_u INTEGER(2) NOT NULL  ,
   username VARCHAR(128) NOT NULL,
   dateConnexion DATETIME NOT NULL,
   etat VARCHAR(128) NOT NULL
   , PRIMARY KEY (id_con) 
 )
 comment = "";


# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
#
#       REFERENCES DES TABLES
#
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////

ALTER TABLE devoir 
  ADD FOREIGN KEY FK_devoir_professeur (id_u)
      REFERENCES professeur (id_u)
         ON DELETE CASCADE ;
ALTER TABLE devoir 
  ADD FOREIGN KEY FK_devoir_classe (id_classe)
      REFERENCES classe (id_classe)
         ON DELETE CASCADE ;
ALTER TABLE piece_jointe 
  ADD FOREIGN KEY FK_piece_jointe_devoir (id_d)
      REFERENCES devoir (id_d)
         ON DELETE CASCADE ;
ALTER TABLE piece_rendu 
  ADD FOREIGN KEY FK_piece_rendu_devoir (id_d)
      REFERENCES devoir (id_d)
         ON DELETE CASCADE ;
ALTER TABLE piece_rendu 
  ADD FOREIGN KEY FK_piece_rendu_eleve (id_u)
      REFERENCES eleve (id_u)
         ON DELETE CASCADE ;
ALTER TABLE administrateur 
  ADD FOREIGN KEY FK_administrateur_user (id_u)
      REFERENCES user (id_u) ;
ALTER TABLE professeur 
  ADD FOREIGN KEY FK_professeur_matiere (id_m)
      REFERENCES matiere (id_m) ;
ALTER TABLE professeur 
  ADD FOREIGN KEY FK_professeur_user (id_u)
      REFERENCES user (id_u)
         ON DELETE CASCADE ;
ALTER TABLE eleve 
  ADD FOREIGN KEY FK_eleve_user (id_u)
      REFERENCES user (id_u)
         ON DELETE CASCADE ;
ALTER TABLE etre 
 ADD FOREIGN KEY FK_etre_eleve (id_u)
     REFERENCES eleve (id_u)
        ON DELETE CASCADE ;
ALTER TABLE etre 
ADD FOREIGN KEY FK_etre_classe (id_classe)
    REFERENCES classe (id_classe)
       ON DELETE CASCADE ;
ALTER TABLE classe 
  ADD FOREIGN KEY FK_classe_session (id_session)
      REFERENCES session (id_session)
         ON DELETE CASCADE ;
ALTER TABLE classe 
  ADD FOREIGN KEY FK_classe_section (id_section)
      REFERENCES section (id_section)
         ON DELETE CASCADE ;
ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_matiere (id_m)
      REFERENCES matiere (id_m)
	     ON DELETE CASCADE ;
ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_classe (id_classe)
      REFERENCES classe (id_classe)
         ON DELETE CASCADE ;
ALTER TABLE cours 
  ADD FOREIGN KEY FK_cours_user (id_u)
      REFERENCES user (id_u)
         ON DELETE CASCADE ;
ALTER TABLE vers_cours 
   ADD FOREIGN KEY FK_vers_cours_cours (id_cours)
       REFERENCES cours (id_cours)
          ON DELETE CASCADE ;
ALTER TABLE assigner 
  ADD FOREIGN KEY FK_assigner_matiere (id_m)
      REFERENCES matiere (id_m)
         ON DELETE CASCADE ;
ALTER TABLE assigner 
  ADD FOREIGN KEY FK_assigner_classe (id_classe)
      REFERENCES classe (id_classe)
         ON DELETE CASCADE ;
 ALTER TABLE vue 
   ADD FOREIGN KEY FK_vue_user (id_u)
       REFERENCES user (id_u)
          ON DELETE CASCADE ;
 ALTER TABLE vue 
   ADD FOREIGN KEY FK_vue_cours (id_cours)
       REFERENCES cours (id_cours)
          ON DELETE CASCADE ;
ALTER TABLE commenter 
  ADD FOREIGN KEY FK_commenter_user (id_u)
      REFERENCES user (id_u)
         ON DELETE CASCADE ;
ALTER TABLE commenter 
  ADD FOREIGN KEY FK_commenter_cours (id_cours)
      REFERENCES cours (id_cours)
         ON DELETE CASCADE ;
ALTER TABLE avoir 
  ADD FOREIGN KEY FK_avoir_devoir (id_d)
      REFERENCES devoir (id_d)
         ON DELETE CASCADE ;
ALTER TABLE avoir 
  ADD FOREIGN KEY FK_avoir_eleve (id_u)
      REFERENCES eleve (id_u)
         ON DELETE CASCADE ;
ALTER TABLE charger 
  ADD FOREIGN KEY FK_charger_classe (id_classe)
      REFERENCES classe (id_classe)
         ON DELETE CASCADE ;
ALTER TABLE charger 
  ADD FOREIGN KEY FK_charger_professeur (id_u)
      REFERENCES professeur (id_u)
         ON DELETE CASCADE ;



# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
#
#       PROCEDURES, FONCTIONS ET TRIGGERS
#
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////

###############################################################################
###############################################################################

#				PROCEDURES LIEES AUX UTILISATEURS

###############################################################################
###############################################################################

# -----------------------------------------------------------------------------
#       FUNCTION : autoincrement() (Auto incrémentation des utilisateurs)
# -----------------------------------------------------------------------------

CREATE PROCEDURE autoincrement(tb VARCHAR(128))
BEGIN
  SELECT COLUMN_NAME INTO @chp
  FROM information_schema.COLUMNS
  WHERE TABLE_NAME = tb
  AND COLUMN_KEY = 'PRI'
  AND TABLE_SCHEMA = 'mylearn';
  
	# SET @chp = chp;
	SET @table = tb;
 	SET @query = CONCAT('SELECT MAX(',@chp,') INTO @newId FROM ',@table);
	PREPARE requete FROM @query;
	EXECUTE requete;
	DEALLOCATE PREPARE requete;

  IF @newId IS NULL
  THEN
    SET @newId = 0;
  END IF;
  SET @newId = @newId+1;
END ;

# -----------------------------------------------------------------------------
#       FUNCTION : autoincrementDev() (Auto incrémentation des devoirs)
# -----------------------------------------------------------------------------

Create function autoincrementDev()
returns INTEGER(2)
  Deterministic
Begin
  Declare nbi int;
  SELECT MAX(id_d) INTO nbi
  FROM devoir;
  IF nbi IS NULL
  THEN
    SET nbi = 0;
  END IF;
  SET nbi = nbi+1;
  return nbi;
END ;

# -----------------------------------------------------------------------------
#       FUNCTION : keygen()
# -----------------------------------------------------------------------------

CREATE FUNCTION keygen(len INTEGER, uniq BOOLEAN)
returns VARCHAR(128)
  Deterministic
BEGIN
	Declare it, al INTEGER DEFAULT 0;
	Declare chars VARCHAR(128);
	Declare result VARCHAR(128);
	Declare one VARCHAR(1);
	Declare test BOOLEAN default true;
	
	SET chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	SET result = "";
	
	IF uniq THEN
		WHILE test DO
			WHILE it < len DO
				SET al = FLOOR(RAND()*LENGTH(chars));
				SET one = SUBSTR(chars, al, 1);
				SET result = CONCAT(result, one);
				SET it = it + 1;
			END WHILE;
			IF (SELECT COUNT(*) FROM user WHERE token = result) < 1 THEN
				SET test = false;
			END IF;
		END WHILE;
	ELSE
		WHILE it < len DO
			SET al = FLOOR(RAND()*LENGTH(chars));
			SET one = SUBSTR(chars, al, 1);
			SET result = CONCAT(result, one);
			SET it = it + 1;
		END WHILE;
	END IF;
	
	Return result;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : ajouter_eleve()
# -----------------------------------------------------------------------------

CREATE PROCEDURE ajouter_eleve(a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_dateNaissance DATE)
BEGIN
	Declare sel, tok, mdp VARCHAR(40);
	Declare md VARCHAR(8);
	Declare surname VARCHAR(128);
	Declare id, it INTEGER DEFAULT 0;
	Declare test BOOLEAN DEFAULT true;
	
	IF (SELECT COUNT(*) FROM user WHERE email = a_email) > 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_MAU";
	ELSE
		CALL autoincrement('user');
		SET id = @newId;
		SET @newId = 0;
		SET tok = (SELECT keygen(40,true));
		SET sel = (SELECT keygen(40,false));
		SET md = (SELECT keygen(8,false));
		SET mdp = SHA1(MD5(CONCAT(SHA1(MD5(sel)), SHA1(MD5(md)), SHA1(md5(Sel)))));
	
		WHILE test DO
			IF it < 1 THEN
				SET surname = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom));
			ELSE
				SET surname = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom, it));
			END IF;
			IF (SELECT COUNT(*) FROM user WHERE username = surname) < 1 THEN
				SET test = false;
			ELSE
				SET it = it + 1;
			END IF;
		END WHILE;
	
		INSERT INTO user VALUES(id, surname, a_nom, a_prenom, a_email, mdp, 0, sel, tok, SYSDATE());
		INSERT INTO eleve VALUES(id, a_dateNaissance);
		SELECT false AS "erreur";
		SELECT id_u AS id, username, nom , prenom, email, md AS password, active, salt, token, dateUser
		FROM user
		WHERE id_u = id;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : up_eleve()
# -----------------------------------------------------------------------------

CREATE PROCEDURE up_eleve(id INTEGER, a_user VARCHAR(128), a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128),a_dateNaissance DATE)
BEGIN
	Declare surname VARCHAR(128);
	Declare sel VARCHAR(40);
	Declare it INTEGER DEFAULT 0;
	Declare test BOOLEAN DEFAULT true;
	
	IF (SELECT COUNT(*) FROM user WHERE email = a_email AND id_u != id) > 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_MAU";
	ELSE
		IF a_user IS NULL OR a_user = "" THEN
			WHILE test DO
				IF it < 1 THEN
					SET a_user = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom));
				ELSE
					SET a_user = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom, it));
				END IF;
				IF (SELECT COUNT(*) FROM user WHERE username = surname AND id_u != id) < 1 THEN
					SET test = false;
				ELSE
					SET it = it + 1;
				END IF;
			END WHILE;
		END IF;
		IF (SELECT password FROM user WHERE id_u = id) != a_pass THEN
			SET sel = (SELECT keygen(40,false));
			SET a_pass = SHA1(MD5(CONCAT(SHA1(MD5(sel)),SHA1(MD5(a_pass)),SHA1(MD5(sel)))));
			UPDATE user SET salt = sel, password = a_pass, token = (SELECT keygen(40,true)) WHERE id_u = id;
		END IF;
		UPDATE user SET
	    username = a_user,
	    nom = a_nom,
	    prenom = a_prenom,
	    email = a_email
	    WHERE id_u = id;
	    UPDATE eleve SET
	    dateNaissance = a_dateNaissance
	    WHERE id_u = id;
		SELECT false AS "erreur";
		SELECT * FROM errors WHERE code = "OP_S";
	END IF;
  
END ;

# -----------------------------------------------------------------------------
#       TRIGGER : del_el
# -----------------------------------------------------------------------------

CREATE TRIGGER del_el
AFTER DELETE ON eleve
FOR EACH ROW
BEGIN
  DELETE FROM user
  WHERE id_u = old.id_u;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : ajouter_prof()
# -----------------------------------------------------------------------------

CREATE PROCEDURE ajouter_prof(a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), matiere INTEGER(2))
BEGIN
	Declare sel, tok, mdp VARCHAR(40);
	Declare md VARCHAR(8);
	Declare surname VARCHAR(128);
	Declare id, it INTEGER DEFAULT 0;
	Declare test BOOLEAN DEFAULT true;

	IF (SELECT COUNT(*) FROM user WHERE email = a_email) > 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_MAU";
	ELSE
		CALL autoincrement('user');
		SET id = @newId;
		SET @newId = 0;
		SET tok = (SELECT keygen(40,true));
		SET sel = (SELECT keygen(40,false));
		SET md = (SELECT keygen(8,false));
		SET mdp = SHA1(MD5(CONCAT(SHA1(MD5(sel)), SHA1(MD5(md)), SHA1(md5(Sel)))));

		WHILE test DO
			IF it < 1 THEN
				SET surname = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom));
			ELSE
				SET surname = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom, it));
			END IF;
			IF (SELECT COUNT(*) FROM user WHERE username = surname) < 1 THEN
				SET test = false;
			ELSE
				SET it = it + 1;
			END IF;
		END WHILE;

		INSERT INTO user VALUES(id, surname, a_nom, a_prenom, a_email, mdp, 0, sel, tok, SYSDATE());
		INSERT INTO professeur VALUES(id, matiere);
		SELECT false AS "erreur";
		SELECT id_u AS id, username, nom , prenom, email, md AS password, active, salt, token, dateUser
		FROM user
		WHERE id_u = id;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : up_prof()
# -----------------------------------------------------------------------------

CREATE PROCEDURE up_prof(id INTEGER, a_user VARCHAR(128), a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), matiere INTEGER(2))
BEGIN
	Declare sel VARCHAR(40);
	Declare it INTEGER DEFAULT 0;
	Declare test BOOLEAN DEFAULT true;

	IF (SELECT COUNT(*) FROM user WHERE email = a_email AND id_u != id) > 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_MAU";
	ELSE
		IF a_user IS NULL OR a_user = "" THEN
			WHILE test DO
				IF it < 1 THEN
					SET a_user = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom));
				ELSE
					SET a_user = LOWER(CONCAT(SUBSTR(a_prenom, 1,1),a_nom, it));
				END IF;
				IF (SELECT COUNT(*) FROM user WHERE username = surname AND id_u != id) < 1 THEN
					SET test = false;
				ELSE
					SET it = it + 1;
				END IF;
			END WHILE;
		END IF;
		IF (SELECT password FROM user WHERE id_u = id) != a_pass THEN
			SET sel = (SELECT keygen(40,false));
			SET a_pass = SHA1(MD5(CONCAT(SHA1(MD5(sel)),SHA1(MD5(a_pass)),SHA1(MD5(sel)))));
			UPDATE user SET salt = sel, password = a_pass, token = (SELECT keygen(40,true)) WHERE id_u = id;
		END IF;
		UPDATE user SET
		username = a_user,
		nom = a_nom,
		prenom = a_prenom,
		email = a_email
		WHERE id_u = id;
		UPDATE professeur SET
		id_m = matiere
		WHERE id_u = id;
		SELECT false AS "erreur";
		SELECT * FROM errors WHERE code = "OP_S";
	END IF;
END ;

# -----------------------------------------------------------------------------
#       TRIGGER : del_prof
# -----------------------------------------------------------------------------

CREATE TRIGGER del_prof
AFTER DELETE ON professeur
FOR EACH ROW
BEGIN
	DELETE FROM user
	WHERE id_u = old.id_u;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_prof()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_prof(prof INTEGER)
BEGIN
	# Professeur
	SELECT id_u AS id, nom, prenom, email
	FROM user
	WHERE id_u = prof;
	
	# MatièreS
	SELECT m.id_m AS id, m.libelle, m.uri, m.icon
	FROM matiere m
	INNER JOIN professeur p ON m.id_m = p.id_m
	WHERE p.id_u = prof;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : ajouter_admin()
# -----------------------------------------------------------------------------

CREATE PROCEDURE ajouter_admin(a_username VARCHAR(128), a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), a_salt VARCHAR(40), a_token VARCHAR(40), a_poste VARCHAR(80))
BEGIN
	Declare id int;
	CALL autoincrement('user');
	SET id = @newId;
	SET @newId = 0;
	IF (SELECT COUNT(*) FROM user u INNER JOIN administrateur a ON a.id_u = u.id_u WHERE u.nom = a_nom AND u.prenom = a_prenom AND a.poste = a_poste) < 1 THEN
		INSERT INTO user VALUES(id, a_username, a_nom, a_prenom, a_email, a_pass, 1, a_salt, a_token, CURDATE());
    	INSERT INTO administrateur VALUES(id, a_poste);
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : up_padmin()
# -----------------------------------------------------------------------------

CREATE PROCEDURE up_admin(id INTEGER, a_username VARCHAR(128), a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), a_active BOOLEAN, a_salt VARCHAR(40), a_token VARCHAR(40), a_poste VARCHAR(80))
BEGIN
	UPDATE user SET
	username = a_username,
	nom = a_nom,
	prenom = a_prenom,
	email = a_email,
	password = a_pass,
	active = a_active,
	salt = a_salt,
	token = a_token
	WHERE id_u = id;
	UPDATE administrateur SET
	poste = a_poste
	WHERE id_u = id;
END ;

# -----------------------------------------------------------------------------
#       TRIGGER : del_admin
# -----------------------------------------------------------------------------

CREATE TRIGGER del_admin
AFTER DELETE ON administrateur
FOR EACH ROW
BEGIN
	DELETE FROM user
	WHERE id_u = old.id_u;
END ;

# -----------------------------------------------------------------------------
#       TRIGGER : up_user
# -----------------------------------------------------------------------------

CREATE TRIGGER up_user
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
	IF old.token != new.token AND old.active = 0 AND new.active = 1 THEN
		DELETE FROM crypt WHERE token = old.token;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       TRIGGER : del_user
# -----------------------------------------------------------------------------

CREATE TRIGGER del_user
BEFORE DELETE ON user
FOR EACH ROW
BEGIN
	IF old.active = 0 AND (SELECT COUNT(*) FROM crypt WHERE token = old.token) > 0 THEN
		DELETE FROM crypt WHERE token = old.token;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       EVENT : maj_token
# -----------------------------------------------------------------------------
CREATE EVENT maj_token
ON SCHEDULE EVERY 6 HOUR STARTS CURRENT_TIMESTAMP DO
BEGIN
	Declare fini int default 0;
	Declare id INTEGER(2);
	Declare cur CURSOR
	FOR SELECT id_u
		FROM user;
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	Open cur;
	FETCH cur INTO id;
	While fini != 1
		DO
			UPDATE user
			SET token = (SELECT keygen(40,true))
			WHERE id_u = id;
			FETCH cur INTO id;
	END While;
	Close cur;
END ;

###############################################################################
###############################################################################

#				PROCEDURES LIEES AUX SESSIONS

###############################################################################
###############################################################################

# -----------------------------------------------------------------------------
#       FUNCTION : trouver_session() (Trouver la session en cours)
# -----------------------------------------------------------------------------

CREATE FUNCTION trouver_session()
returns VARCHAR(10)
	Deterministic
Begin
	Declare sess INTEGER;
	IF MONTH(CURDATE()) < 8
	THEN
		SELECT id_session INTO sess
		FROM session
		WHERE session like CONCAT("%/",YEAR(CURDATE()));
	ELSE
		SELECT id_session INTO sess
		FROM session
		WHERE session like CONCAT(YEAR(CURDATE()),"/%");
	END IF;
	IF sess IS NULL
	THEN
		SET sess = "NOT FOUND";
	END IF;
	return sess;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : ajouter_session()
# -----------------------------------------------------------------------------

CREATE PROCEDURE ajouter_session(sess VARCHAR(10))
BEGIN
	Declare prev, next INTEGER;
	IF sess = "FIRST"
		THEN
			IF MONTH(CURDATE()) < 7
			THEN
				INSERT INTO session VALUES('',CONCAT(YEAR(CURDATE())-1,'/',YEAR(CURDATE())));
			ELSE
				INSERT INTO session VALUES('',CONCAT(YEAR(CURDATE()),"/",YEAR(CURDATE())+1));
			END IF;
		ELSE
		    INSERT INTO session VALUES('',sess);
		    SELECT id_session INTO prev
		    FROM session
		    WHERE session like CONCAT("%/",SUBSTR(sess,1,4));
		    IF prev IS NOT NULL
		    THEN
				  SELECT id_session INTO next
				  FROM session
				  WHERE session LIKE sess;
          CALL auto_class(prev, next);
   		END IF;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : auto_class() (Création auto des classes pour une session)
# -----------------------------------------------------------------------------

CREATE PROCEDURE auto_class(prev INTEGER, next INTEGER)
BEGIN
	Declare fini int default 0;
	Declare c_section INTEGER(2);
	Declare c_libelle VARCHAR(128);
	Declare c_uri VARCHAR(128); 
	Declare curc CURSOR
	FOR SELECT id_section, libelle, uri
		FROM classe c
		INNER JOIN session s ON c.id_session = s.id_session
		WHERE s.id_session = prev;
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	Open curc;
	FETCH curc INTO c_section, c_libelle, c_uri;
	While fini != 1
		DO
			INSERT INTO classe VALUES("", next, c_section, c_libelle, c_uri);
			FETCH curc INTO c_section, c_libelle, c_uri;
	END While;
	Close curc;
END ;

###############################################################################
###############################################################################

#				PROCEDURES LIEES AUX COURS

###############################################################################
###############################################################################

# -----------------------------------------------------------------------------
#       PROCEDURE : ajouter_devoir
# -----------------------------------------------------------------------------
CREATE PROCEDURE ajouter_devoir(prof INTEGER, class INTEGER, lib VARCHAR(1024), sumary TEXT, max DATE)
BEGIN
	Declare fini int default 0;
	Declare id,devoir INTEGER(2);
	Declare curc CURSOR
	FOR SELECT id_u
		FROM etre
		WHERE id_classe = class;
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	CALL autoincrement('devoir');
	SET devoir = @newId;
	SET @newId = 0;
	
	INSERT INTO devoir SET id_d = devoir, id_u = prof, id_classe = class, dateDevoir = CURDATE(), libelle = lib, enonce = sumary, dateMax = max;
	
	Open curc;
	FETCH curc INTO id;
	While fini != 1
		DO
			INSERT INTO avoir set id_u = id, id_d = devoir;
			FETCH curc INTO id;
	END While;
	Close curc;
	CALL select_devoir(devoir, prof, true);
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : up_devoir
# -----------------------------------------------------------------------------
CREATE PROCEDURE up_devoir(id INTEGER, lib VARCHAR(1024), sumary TEXT, max DATE, actif BOOLEAN)
BEGIN
	UPDATE devoir SET libelle = lib, enonce = sumary, dateMax = max, active = actif WHERE id_d = id;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_devoirs
# -----------------------------------------------------------------------------
CREATE PROCEDURE select_devoirs(user INTEGER, prof BOOLEAN)
BEGIN
	Declare id INTEGER;
	Declare fini int default 0;
	Declare curp CURSOR
	FOR SELECT id_d
		FROM devoir
		WHERE id_u = user
		ORDER BY dateDevoir;
	Declare cure CURSOR
	FOR SELECT d.id_d
		FROM devoir d
		INNER JOIN etre et ON et.id_classe = d.id_classe
		WHERE et.id_u = user
		AND d.active = TRUE
		ORDER BY dateDevoir;
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;

	IF prof THEN
		SELECT COUNT(id_d) AS 'Devoirs'
		FROM devoir
		WHERE id_u = user;
		OPEN curp;
		FETCH curp INTO id;
		WHILE fini != 1 DO
			CALL select_devoir(id, user, true);
			FETCH curp INTO id;
		END WHILE;
	ELSE
		SELECT COUNT(id_d) AS 'Devoirs'
		FROM devoir d
		INNER JOIN etre et ON et.id_classe = d.id_classe
		WHERE et.id_u = user
		AND d.active = TRUE;
		OPEN cure;
		FETCH cure INTO id;
		WHILE fini != 1 DO
			CALL select_devoir(id, user, false);
			FETCH cure INTO id;
		END WHILE;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_devoir
# -----------------------------------------------------------------------------
CREATE PROCEDURE select_devoir(devoir INTEGER, user INTEGER, prof BOOLEAN)
BEGIN
	Declare classe, professeur, eleve INTEGER;
	Declare fini int default 0;
	Declare curc CURSOR
	FOR SELECT id_u
		FROM avoir
		WHERE id_d = devoir;
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	IF (SELECT COUNT(*) FROM devoir WHERE id_d = devoir) > 0 THEN
	
		IF (SELECT COUNT(id_u) FROM avoir WHERE id_d = devoir AND id_u = user) > 0 OR (SELECT COUNT(id_u) FROM devoir WHERE id_d = devoir AND id_u = user) THEN
			SELECT false AS "erreur";
	
			# Devoir
			SELECT id_d AS id, dateDevoir, libelle, enonce, dateMax, active
			FROM devoir
			WHERE id_d = devoir;
	
			# Classe
			SELECT id_classe INTO classe
			FROM devoir
			WHERE id_d = devoir;
	
			CALL select_class(classe);
	
			# Professeur
			SELECT id_u INTO professeur
			FROM devoir
			WHERE id_d = devoir;
	
			CALL select_prof(professeur);
	
			# Pieces jointes
			CALL select_piece_jointe(devoir);
	
			# Eleves
			IF prof THEN
				SELECT COUNT(id_u) AS 'Cibles'
				FROM avoir
				WHERE id_d = devoir;
				OPEN curc;
				FETCH curc INTO eleve;
				WHILE fini != 1 DO
					CALL select_devoir_rendu(devoir, eleve);
					FETCH curc INTO eleve;
				END WHILE;
			ELSE
				SELECT 'unique' AS 'Cibles';
				CALL select_devoir_rendu(devoir, user);
			END IF;
		ELSE
			SELECT true AS "erreur";
			SELECT * FROM errors WHERE code = "DEV_NA";
		END IF;
	ELSE
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "DEV_NF";
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_piece_jointe
# -----------------------------------------------------------------------------
CREATE PROCEDURE select_piece_jointe(devoir INTEGER)
BEGIN
	Declare nbp INTEGER;
	
	SELECT COUNT(*) INTO nbp
	FROM piece_jointe
	WHERE id_d = devoir;
	
	SELECT nbp AS 'Pieces jointes';
	
	IF nbp > 0 THEN
		SELECT id_pj AS id, libelle, chemin, dateUpload
		FROM piece_jointe
		WHERE id_d = devoir;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_devoir_rendu
# -----------------------------------------------------------------------------
CREATE PROCEDURE select_devoir_rendu(devoir INTEGER, eleve INTEGER)
BEGIN
	Declare nbp INTEGER;
	
	SELECT devoir AS id, commentaire, note
	FROM avoir
	WHERE id_u = eleve
	AND id_d = devoir;
	
	SELECT id_u AS id, nom, prenom, email
	FROM user
	WHERE id_u = eleve;
	
	SELECT COUNT(*) INTO nbp
	FROM piece_rendu
	WHERE id_u = eleve
	AND id_d = devoir;
	
	SELECT nbp AS 'Pieces rendues';
	
	IF nbp > 0 THEN
		SELECT id_pr AS id, libelle, chemin, dateUpload
		FROM piece_rendu
		WHERE id_u = eleve
		AND id_d = devoir;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       TRIGGER : version_cours (Versionning de cours)
# -----------------------------------------------------------------------------

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
    # /!\ ATTENTION /!\ pour trouver le dateModif le plus petit, il faut utiliser une sous-requête avec un alias, car l on cherche dans la table ou l on veut supprimer cela bloque la table en question !!
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
  INSERT INTO vers_cours VALUES(new.id_cours,old.titre,old.uri,old.description,old.contenu,sysdate());
  SET new.dateModif = sysdate();
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : restaurer_cours() (Restaurer un cours)
# -----------------------------------------------------------------------------

CREATE PROCEDURE restaurer_cours(id int, version DATETIME)
BEGIN
  # Déclaration
  Declare v_titre, v_desc VARCHAR(128);
  Declare v_contenu TEXT;
  # Récupération du titre, description et contenu de la version choisie
  SELECT titre, description, contenu INTO v_titre, v_desc, v_contenu
  FROM vers_cours 
  WHERE id_cours = id
  AND dateModif = version;
  # Insertion des informations récupérés dans le cours choisi
  UPDATE cours 
  SET titre = v_titre, 
  description = v_desc,
  contenu = v_contenu
  WHERE id_cours = id;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_classes()
# -----------------------------------------------------------------------------
/*
	Cherche toutes les classes ou toutes les classes dans lesquelle est UN élève
	et dont la session max est celle actuelle ou un professeur
*/
CREATE PROCEDURE select_classes(user INTEGER, eleve BOOLEAN)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare id INTEGER;
	
	# Premier curseur
	Declare cur1 CURSOR
	FOR SELECT id_classe
		FROM classe;
		
	# Deuxième curseur
	Declare cur2 CURSOR
	FOR SELECT c.id_classe
		FROM classe c
		INNER JOIN etre e ON c.id_classe = e.id_classe
		INNER JOIN session s ON s.id_session = c.id_session
		WHERE e.id_u = user
		AND s.id_session IN (
			SELECT id_session
			FROM session
			GROUP BY id_session
			HAVING SUBSTR(session,6) <= YEAR(CURDATE())
		)
		ORDER BY s.session DESC;
		
	# Troisième curseur
	Declare cur3 CURSOR
	FOR SELECT c.id_classe
		FROM classe c
		INNER JOIN charger ch ON c.id_classe = ch.id_classe
		INNER JOIN professeur p ON p.id_u = ch.id_u
		INNER JOIN assigner a ON a.id_classe = c.id_classe AND a.id_m = p.id_m
		INNER JOIN session s ON s.id_session = c.id_session
		WHERE ch.id_u = user
		AND s.id_session IN (
			SELECT id_session
			FROM session
			GROUP BY id_session
			HAVING SUBSTR(session,6) <= YEAR(CURDATE())
		)
		ORDER BY s.session DESC;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
		
	# Nombre de classes trouvée
	IF user IS NULL OR user = 0 THEN
		SELECT COUNT(*) AS "Classes" FROM classe;
		Open cur1;
		FETCH cur1 INTO id;
		WHILE fini != 1	DO
			CALL select_class(id);
			FETCH cur1 INTO id;
		END WHILE;
		Close cur1;
	ELSE
		IF eleve IS true THEN
			SELECT COUNT(*) AS "Classes"
			FROM classe c
			INNER JOIN etre e ON c.id_classe = e.id_classe
			INNER JOIN session s ON s.id_session = c.id_session
			WHERE e.id_u = user
			AND s.id_session IN (
				SELECT id_session
				FROM session
				GROUP BY id_session
				HAVING SUBSTR(session,6) <= YEAR(CURDATE())
			);
			Open cur2;
			FETCH cur2 INTO id;
			WHILE fini != 1 DO
				CALL select_class(id);
				FETCH cur2 INTO id;
			END WHILE;
			Close cur2;
		ELSE
			SELECT COUNT(*) AS "Classes"
			FROM classe c
			INNER JOIN charger ch ON c.id_classe = ch.id_classe
			INNER JOIN professeur p ON p.id_u = ch.id_u
			INNER JOIN assigner a ON a.id_classe = c.id_classe AND a.id_m = p.id_m
			INNER JOIN session s ON s.id_session = c.id_session
			WHERE ch.id_u = user
			AND s.id_session IN (
				SELECT id_session
				FROM session
				GROUP BY id_session
				HAVING SUBSTR(session,6) <= YEAR(CURDATE())
			);
			Open cur3;
			FETCH cur3 INTO id;
			WHILE fini != 1 DO
				CALL select_class(id);
				FETCH cur3 INTO id;
			END WHILE;
			Close cur3;
		END IF;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_class()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_class(classe INTEGER)
BEGIN
	# Classe
	SELECT id_classe AS id, libelle, uri
	FROM classe
	WHERE id_classe = classe;
	
	# Session
	SELECT s.id_session AS id, s.session
	FROM session s
	INNER JOIN classe c ON s.id_session = c.id_session
	WHERE c.id_classe = classe;
	
	# Section
	SELECT s.id_section AS id, s.id_u AS admin, s.libelle
	FROM section s
	INNER JOIN classe c ON s.id_section = c.id_section
	WHERE c.id_classe = classe;
	
	# MatièreS
	SELECT m.id_m AS id, m.libelle, m.uri, m.icon, (SELECT COUNT(*) FROM cours c WHERE c.id_m = m.id_m AND c.id_classe = classe) AS "cours"
	FROM matiere m
	INNER JOIN assigner a ON m.id_m = a.id_m
	WHERE a.id_classe = classe
	ORDER BY m.libelle;
	
	# ProfesseurS
	SELECT u.id_u AS id, u.nom, u.prenom, u.email
	FROM user u
	INNER JOIN charger c ON u.id_u = c.id_u
	INNER JOIN professeur p ON u.id_u = p.id_u
	WHERE c.id_classe = classe;
	
	# ElèveS
	SELECT u.id_u AS id, u.nom, u.prenom, u.email
	FROM user u
	INNER JOIN etre e ON u.id_u = e.id_u
	INNER JOIN eleve p ON u.id_u = p.id_u
	WHERE e.id_classe = classe;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_variable_result()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_variable_result(util INTEGER, sess VARCHAR(128), class VARCHAR(128), mat VARCHAR(128), qte INTEGER, page INTEGER, titre_cours VARCHAR(128))
BEGIN
	Declare idc,idm,idcr INTEGER;
	Declare debut TIME;
	Declare fin TIME;
	
	
	SET debut = CURTIME(4);
	
	# Recherche la classe avec la liste des matières
	SELECT c.id_classe INTO idc
	FROM classe c
	INNER JOIN session s ON s.id_session = c.id_session
	WHERE c.uri = class
	AND s.session = sess;
	
	IF idc IS NULL OR idc = 0 THEN
		SELECT true AS "erreur";
		SELECT * from errors WHERE code = "CL_NF";
	ELSE
		IF (SELECT COUNT(*) FROM etre WHERE id_u = util AND id_classe = idc) > 0 OR (SELECT COUNT(*) FROM charger WHERE id_u = util AND id_classe = idc) > 0 THEN
			IF (MONTH(CURDATE()) < 8 AND SUBSTR(sess,1,4) < YEAR(CURDATE())) OR (MONTH(CURDATE()) > 8 AND SUBSTR(sess,1,4) <= YEAR(CURDATE())) THEN
				# Selection de la classe
				SELECT false AS "erreur";
				CALL select_class(idc);
				
				# Recherche de la matière avec la liste des cours
				IF mat IS NOT NULL AND mat != "" THEN
					SELECT m.id_m INTO idm
					FROM matiere m
					INNER JOIN assigner a ON a.id_m = m.id_m
					WHERE m.uri = mat
					AND a.id_classe = idc;
					IF idm IS NULL OR idm = 0 THEN
						SELECT true AS "erreur";
						SELECT * from errors WHERE code = "MT_NF";
					ELSE
						# Select de la matiere
						SELECT false AS "erreur";
						IF titre_cours IS NOT NULL OR titre_cours != "" THEN
							CALL select_matiere(idc,idm,NULL,NULL);
							SELECT c.id_cours INTO idcr
							FROM cours c
							INNER JOIN matiere m ON m.id_m = c.id_m
							INNER JOIN classe cl ON cl.id_classe = c.id_classe
							WHERE c.uri = titre_cours
							AND m.id_m = idm
							AND cl.id_classe = idc;
							IF idcr IS NULL OR idcr = 0 THEN
								SELECT true AS "erreur";
								SELECT * from errors WHERE code = "CR_NF";
							ELSE
								# Selection du cours
								SELECT false AS "erreur";
								INSERT INTO vue SET id_u = util, id_cours = idcr, dateVue = sysdate();
								CALL select_cours(idcr, false);
							END IF;
						ELSE
							CALL select_matiere(idc,idm,qte,page);
						END IF;
					END IF;
				END IF;
			ELSE
				SELECT true AS "erreur";
				SELECT * from errors WHERE code = "CL_ND";
			END IF;
		ELSE
			SELECT true AS "erreur";
			SELECT * from errors WHERE code = "CL_NA";
		END IF;
	END IF;
	SET fin = CURTIME(4);
	#SELECT debut,fin,TIMEDIFF(fin,debut) AS "Compteur";
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_matiere()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_matiere(class INTEGER, mat INTEGER, qte INTEGER, page INTEGER)
BEGIN
	Declare id, debut INTEGER;
	IF class IS NULL OR class = 0 THEN
		IF qte IS NULL THEN
			SELECT m.id_m AS id, m.libelle, m.uri, m.icon, (SELECT COUNT(*) FROM cours c WHERE c.id_m = m.id_m) AS "cours"
			FROM matiere m 
			WHERE m.id_m = mat;
		ELSE
			SELECT m.id_m AS id, m.libelle, m.uri, m.icon, (
				SELECT COUNT(*)
				FROM cours c
				INNER JOIN professeur p ON p.id_m = c.id_m
				INNER JOIN charger ch ON ch.id_u = p.id_u AND ch.id_classe = c.id_classe
				WHERE c.id_m = m.id_m
				AND p.id_u = qte) AS "cours"
			FROM matiere m
			WHERE m.id_m = mat;
		END IF;
	ELSE
		IF (qte IS NULL OR qte = 0) AND (page IS NULL OR page = 0) THEN
			SELECT m.id_m AS id, m.libelle, m.uri, m.icon, (
				SELECT COUNT(*)
				FROM cours c
				WHERE c.id_m = m.id_m
				AND c.id_classe = class) AS "cours"
			FROM matiere m
			WHERE m.id_m = mat;
		ELSE
			SELECT id_m AS id, libelle, uri, icon
			FROM matiere
			WHERE id_m = mat;
			IF page < 2 THEN
				SET debut = 0;
			ELSE
				SET debut = qte * (page - 1);
			END IF;
			IF (SELECT COUNT(*) AS "Cours" FROM (SELECT * FROM cours WHERE id_m = mat AND id_classe = class LIMIT debut,qte) AS test) > 0 THEN
				SELECT false AS "erreur";
				CALL select_matiere_cours(mat,class,qte,debut);
			ELSE
				IF debut > 0 THEN
					SELECT true AS "erreur";
					SELECT * from errors WHERE code = "CR_PNF";
				ELSE
					SELECT true AS "erreur";
					SELECT * from errors WHERE code = "CR_NOC";
				END IF;
			END IF;
		END IF;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_matiere_cours()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_matiere_cours(mat INTEGER, class INTEGER, qte INTEGER, debut INTEGER)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare id, page INTEGER;
	
	# Curseur 1
	Declare cur1 CURSOR
	FOR SELECT id_cours
		FROM cours
		WHERE id_m = mat
		ORDER BY dateAjout DESC;
		
	# Curseur 2
	Declare cur2 CURSOR
	FOR SELECT id_cours
		FROM cours
		WHERE id_m = mat
		AND id_classe = class
		ORDER BY dateAjout DESC
		LIMIT debut,qte;
	
	# Curseur 3
	Declare cur3 CURSOR
	FOR SELECT c.id_cours
		FROM cours c
		INNER JOIN etre e ON e.id_classe = c.id_classe
		WHERE e.id_u = qte
		AND c.id_m = mat
		ORDER BY dateAjout Desc;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	# Nombre de cours
	IF class IS NULL OR class = 0 THEN
		IF qte IS NULL OR qte = 0 THEN
			SELECT COUNT(*) AS "Cours_1" FROM cours WHERE id_m = mat;
			Open cur1;
			FETCH cur1 INTO id;
			WHILE fini != 1	DO
				CALL select_cours(id, false);
				FETCH cur1 INTO id;
			END WHILE;
			Close cur1;
		ELSE
			SELECT COUNT(c.id_cours) AS "Cours"
			FROM cours c
			INNER JOIN etre e ON e.id_classe = c.id_classe
			WHERE id_m = mat
			AND e.id_u = qte;
			Open cur3;
			FETCH cur3 INTO id;
			WHILE fini != 1	DO
				CALL select_cours(id, true);
				FETCH cur3 INTO id;
			END WHILE;
			Close cur3;
		END IF;
	ELSE
		IF MOD((SELECT COUNT(*) FROM cours WHERE id_m = mat AND id_classe = class),qte) = 0 THEN
			SET page = (SELECT COUNT(*) FROM cours WHERE id_m = mat AND id_classe = class)/qte;
		ELSE
			SET page = FLOOR((SELECT COUNT(*) FROM cours WHERE id_m = mat AND id_classe = class)/qte) + 1;
		END IF;
		SELECT page AS "Pages";
		SELECT COUNT(*) AS "Cours" FROM (SELECT * FROM cours WHERE id_m = mat AND id_classe = class LIMIT debut,qte) AS test;
		Open cur2;
		FETCH cur2 INTO id;
		WHILE fini != 1 DO
			CALL select_cours(id, false);
			FETCH cur2 INTO id;
		END WHILE;
		Close cur2;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_lastfav()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_lastfav(user INTEGER)
BEGIN
	# Déclaration
	Declare fini INTEGER default 0;
	Declare id, vues, fav, last INTEGER;
	
	# Curseur 1
	Declare cur1 CURSOR
	FOR SELECT c.id_cours AS 'Cours',COUNT(v.id_v) 
		FROM cours c
		INNER JOIN etre e ON e.id_classe = c.id_classe
		INNER JOIN vue v ON c.id_cours = v.id_cours
		AND c.id_u <> v.id_u
		WHERE e.id_u = user
		GROUP BY c.id_cours
		ORDER BY COUNT(v.id_v) DESC
		LIMIT 0,5;
		
	# Curseur 2
	Declare cur2 CURSOR
	FOR SELECT c.id_cours
		FROM cours c
		INNER JOIN etre e ON e.id_classe = c.id_classe
		WHERE e.id_u = user
		ORDER BY dateAjout DESC
		LIMIT 0,5;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	SELECT COUNT(*) INTO fav FROM (
		SELECT c.id_cours
		FROM cours c
		INNER JOIN vue v ON c.id_cours = v.id_cours
		AND c.id_u <> v.id_u
		INNER JOIN etre e ON e.id_classe = c.id_classe
		WHERE e.id_u = user
		GROUP BY c.id_cours
	) AS requete;
	
	SELECT fav AS 'Favorites';
	
	IF fav > 0 THEN
		Open cur1;
		FETCH cur1 INTO id, vues;
		WHILE fini != 1	DO
			CALL select_cours(id, true);
			FETCH cur1 INTO id, vues;
		END WHILE;
		Close cur1;
		SET fini = 0;
	END IF;
	
	SELECT COUNT(*) INTO last
	FROM (
		SELECT c.id_cours
		FROM cours c
		INNER JOIN etre e ON e.id_classe = c.id_classe
		WHERE e.id_u = user
		ORDER BY dateAjout DESC
		LIMIT 0,5
	 ) AS requete;
	
	SELECT last AS 'Last';
	
	IF last > 0 THEN
		Open cur2;
		FETCH cur2 INTO id;
		WHILE fini != 1	DO
			CALL select_cours(id, true);
			FETCH cur2 INTO id;
		END WHILE;
		Close cur2;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : ajouter_cours()
# -----------------------------------------------------------------------------

CREATE PROCEDURE ajouter_cours(user INTEGER, class INTEGER, mat INTEGER, title VARCHAR(1024), url VARCHAR(1024), descr TEXT, cont TEXT)
BEGIN
	Declare id INTEGER;
	CALL autoincrement('cours');
	SET id = @newId;
	SET @newId = 0;
	INSERT INTO cours
	SET id_cours = id, id_u = user, id_classe = class, id_m = mat, titre = title, uri = CONCAT(id,'-',url), description = descr, contenu = cont, dateAjout = sysdate(), dateModif = sysdate();
	CALL select_cours(id, true);
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : up_cours()
# -----------------------------------------------------------------------------

CREATE PROCEDURE up_cours(id INTEGER, class INTEGER, mat INTEGER, title VARCHAR(1024), url VARCHAR(1024), descr TEXT, cont TEXT)
BEGIN
	UPDATE cours
	SET id_classe = class, id_m = mat, titre = title, uri = CONCAT(id,'-',url), description = descr, contenu = cont
	WHERE id_cours = id;
END ;
	
# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours(cours INTEGER, complet BOOLEAN)
BEGIN
	Declare classe INTEGER;
	Declare id, idc, idm INTEGER;
	DECLARE no_cours CONDITION FOR 1329;
	DECLARE EXIT HANDLER FOR no_cours
	BEGIN
		SELECT "Ce cours n'existe pas" AS "Message";
	END;
	
	IF complet = true THEN
		SELECT id_classe, id_m INTO idc, idm
		FROM cours
		WHERE id_cours = cours;
		CALL select_class(idc);
		CALL select_matiere(idc,idm,NULL,NULL);
	END IF;
	
	# Cours	
	SELECT id_cours AS id, titre, uri, description, contenu, dateAjout, dateModif
	FROM cours
	WHERE id_cours = cours;
	
	# Auteur
	SELECT u.id_u AS id, u.username, u.nom, u.prenom, u.email, u.dateUser
	FROM user u
	INNER JOIN cours c ON c.id_u = u.id_u
	WHERE c.id_cours = cours;
	
	# Commentaires
	CALL select_cours_com(cours);
	
	# Vues
	CALL select_cours_vue(cours);
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_vue()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_vue(id INTEGER)
BEGIN
	# Commentaire
	SELECT id_v AS id, id_cours AS cours, dateVue
	FROM vue
	WHERE id_v = id;
	
	# Auteur
	SELECT u.id_u AS id, u.username, u.nom, u.prenom, u.email, u.dateUser
	FROM user u
	INNER JOIN vue v ON v.id_u = u.id_u
	WHERE v.id_v = id;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_vue()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_vue(cours INTEGER)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare vue INTEGER;
	
	# Curseur
	Declare cur1 CURSOR
	FOR SELECT v.id_v
		FROM vue v
		INNER JOIN cours c ON c.id_cours = v.id_cours
		WHERE v.id_cours = cours
		AND c.id_u <> v.id_u;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	# Nombre de cours
	SELECT COUNT(*) AS "Vues"
	FROM vue v
	INNER JOIN cours c ON c.id_cours = v.id_cours
	WHERE v.id_cours = cours
	AND c.id_u <> v.id_u;
	
	# Ouverture du curseur
	Open cur1;
	FETCH cur1 INTO vue;
	WHILE fini != 1	DO
		CALL select_vue(vue);
		FETCH cur1 INTO vue;
	END WHILE;
	Close cur1;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_comm()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_com(com INTEGER)
BEGIN
	# Commentaire
	SELECT id_com AS id, dateCommentaire, commentaire
	FROM commenter
	WHERE id_com = com;
	
	# Auteur
	SELECT u.id_u AS id, u.username, u.nom, u.prenom, u.email, u.dateUser
	FROM user u
	INNER JOIN commenter c ON c.id_u = u.id_u
	WHERE id_com = com;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_com()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_com(cours INTEGER)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare com INTEGER;
	
	# Curseur
	Declare cur1 CURSOR
	FOR SELECT id_com
		FROM commenter
		WHERE id_cours = cours
		ORDER BY dateCommentaire;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	# Nombre de cours
	SELECT COUNT(*) AS "Commentaires"
	FROM commenter
	WHERE id_cours = cours;
	
	# Ouverture du curseur
	Open cur1;
	FETCH cur1 INTO com;
	WHILE fini != 1	DO
		CALL select_com(com);
		FETCH cur1 INTO com;
	END WHILE;
	Close cur1;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_auteur()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_auteur(user INTEGER)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare id, idc, idm INTEGER;
	
	# Curseur
	Declare cur1 CURSOR
	FOR SELECT c.id_cours, c.id_classe, c.id_m
		FROM cours c
		INNER JOIN user u ON u.id_u = c.id_u
		WHERE u.id_u = user;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	# Nombre de cours
	SELECT COUNT(*) AS "Cours"
	FROM cours
	WHERE id_u = user;
	
	# Ouverture du curseur
	Open cur1;
	FETCH cur1 INTO id, idc, idm;
	WHILE fini != 1	DO
		CALL select_class(idc);
		CALL select_matiere(idc,idm,NULL,NULL);
		CALL select_cours(id, false);
		FETCH cur1 INTO id, idc, idm;
	END WHILE;
	Close cur1;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : search_engine()
# -----------------------------------------------------------------------------

CREATE PROCEDURE search_engine(chaine TEXT, user INTEGER)
BEGIN
	Declare it, nb, id, done INTEGER default 0;
	Declare pre INTEGER default 1;
	Declare clause,query TEXT default "";
	
	# Curseur
	Declare cur1 CURSOR
	FOR SELECT id_cours
		FROM search_results;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET done = 1;
	
	# Suppression de la table temporaire si elle existe
	DROP TABLE IF EXISTS search_results;
	
	# Création de la requete avec la clause LIKE
	SET query = CONCAT('SELECT c.id_cours FROM cours c INNER JOIN classe cl ON c.id_classe = cl.id_classe INNER JOIN matiere m ON m.id_m = c.id_m INNER JOIN etre e ON e.id_classe = cl.id_classe WHERE e.id_u = ',user, ' AND (');
	SET clause = '\"%';
	IF LENGTH(chaine) > 0 THEN
		SET nb = nb + 1;
		IF  LOCATE('+',chaine) > 0 THEN
			SET it = LOCATE('+',chaine);
			SET clause = CONCAT(clause,SUBSTR(chaine, pre, it-1),'%');
			SET pre = it + 1;
			
			WHILE it != 0	DO
				SET nb = nb + 1;
				SET it = LOCATE('+',chaine, pre);
				
					IF it > 0 THEN
						SET clause = CONCAT(clause,SUBSTR(chaine, pre, it-pre),'%');
					ELSE
						SET clause = CONCAT(clause,SUBSTR(chaine, pre),'%');
					END IF;
				SET pre = it + 1;
			END WHILE;
		ELSE
			SET clause = CONCAT(clause,chaine,'%');
		END IF;
		SET clause = CONCAT(clause,'\"');
	END IF;
	SET query = CONCAT(query, 'c.titre LIKE ',clause, ' OR c.description LIKE ',clause, ' OR c.contenu LIKE ',clause, ' OR cl.libelle LIKE ',clause, 'OR m.libelle LIKE ',clause, ') ORDER BY dateAjout DESC');
	SET query = CONCAT('CREATE TEMPORARY TABLE IF NOT EXISTS search_results AS (', query,');');
	# SELECT query, nb;
	SET @query = query;
	# Création de la table temporaire
	PREPARE requete FROM @query;
	EXECUTE requete;
	DEALLOCATE PREPARE requete;
	
	# Compte du nombre de résultat
	SELECT COUNT(*) AS "Cours" FROM search_results;
	
	IF (SELECT COUNT(*) FROM search_results) > 0 THEN
		# Ouverture du curseur
		OPEN cur1;
		FETCH cur1 INTO id;
		WHILE done != 1	DO
			CALL select_cours(id, true);
			FETCH cur1 INTO id;
		END WHILE;
		Close cur1;
		SET done = 0;
	END IF;
END ;

###############################################################################
###############################################################################

#				PROCEDURES LIEES AU COMPTE UTILISATEUR

###############################################################################
###############################################################################

# -----------------------------------------------------------------------------
#       PROCEDURE : connexion()
# -----------------------------------------------------------------------------

CREATE PROCEDURE connexion(login VARCHAR(128), pass VARCHAR(128))
BEGIN
	DECLARE id, mat INTEGER(2);
	DECLARE user VARCHAR(128);
	DECLARE name VARCHAR(128);
	DECLARE last VARCHAR(128);
	DECLARE mail VARCHAR(128);
	DECLARE passwd VARCHAR(128);
	DECLARE actif BOOLEAN;
	DECLARE sel VARCHAR(40);
	DECLARE tok VARCHAR(40);
	DECLARE dateU DATE;
	DECLARE no_user_for_login CONDITION FOR 1329;
	
	DECLARE EXIT HANDLER FOR no_user_for_login
	BEGIN
		# - - - Logs de connexion
		INSERT INTO logs_con SET id_u = 0, username = login, dateConnexion = SYSDATE(), etat = "Mauvais login";
		# - - -
		SELECT true AS "erreur";
		SELECT "Erreur de saisie identidiant/mot de passe" AS "Message", "danger" AS "Type";
	END;
	
	SELECT id_u, username, salt INTO id, user, sel
	FROM user
	WHERE username = login;

	SET passwd = SHA1(MD5(CONCAT(SHA1(MD5(sel)),SHA1(pass),SHA1(MD5(sel)))));
	
	IF (SELECT COUNT(*) FROM user WHERE username = login AND password = passwd) > 0 THEN
		SELECT id_u,username,nom,prenom,email,password,active,salt,token,dateUser INTO id,user,name,last,mail,passwd,actif,sel,tok,dateU
		FROM user
		WHERE username = login AND password = passwd;
		IF actif THEN
			# - - - Logs de connexion
			INSERT INTO logs_con SET id_u = id, username = user, dateConnexion = SYSDATE(), etat = "Connexion réussie";
			# - - -
			SELECT false AS "erreur";
			SELECT id, user AS username, name AS nom, last AS prenom, mail AS email, passwd AS password, actif AS active, sel AS salt, tok AS token, dateU AS dateUser;
			IF (SELECT COUNT(*) FROM administrateur WHERE id_u = id) > 0 THEN
				SELECT "Admin" AS "Statut";
			ELSEIF (SELECT COUNT(*) FROM professeur WHERE id_u = id) > 0 THEN
				SELECT "Prof" AS "Statut";
				SELECT id_m INTO mat FROM professeur WHERE id_u = id;
				CALL select_matiere(NULL,mat,id,NULL);
				CALL select_classes(id,false);
			ELSEIF (SELECT COUNT(*) FROM eleve WHERE id_u = id) > 0 THEN
				SELECT "Eleve" AS "Statut";
				CALL select_classes(id,true);
			END IF;
		ELSE
			# - - - Logs de connexion
			INSERT INTO logs_con SET id_u = id, username = user, dateConnexion = SYSDATE(), etat = "Compte non activé";
			# - - -
			SELECT true AS "erreur";
			SELECT "Votre compte n'est pas encore activÃ©" AS "Message", "warning" AS "Type";
		END IF;
	ELSE
		# - - - Logs de connexion
		INSERT INTO logs_con SET id_u = id, username = user, dateConnexion = SYSDATE(), etat = "Mauvais mot de passe";
		# - - -
		SELECT true AS "erreur";
		SELECT "Erreur de saisie identidiant/mot de passe" AS "Message", "danger" AS "Type";
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : activation()
# -----------------------------------------------------------------------------

CREATE PROCEDURE activation(oldtk VARCHAR(40))
BEGIN
	Declare id INTEGER;
	Declare actif INTEGER;
	SELECT id_u, active INTO id,actif
	FROM user
	WHERE token = oldtk;
	
	IF id IS NULL OR id = 0 THEN
		SELECT * FROM errors WHERE code = "ACT_WT";
	ELSE
		IF actif = 0 THEN
			UPDATE user
			SET active = 1,
			token = (SELECT keygen(40,true))
			WHERE id_u = id;
			SELECT * FROM errors WHERE code = "ACT_S";
		ELSE
			SELECT * FROM errors WHERE code = "ACT_AA";
		END IF;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : activation_request()
# -----------------------------------------------------------------------------

CREATE PROCEDURE activation_request(mail VARCHAR(128))
BEGIN
	Declare id INTEGER;
	Declare actif INTEGER;
	Declare tk VARCHAR(40);
	SELECT id_u, active,token INTO id,actif,tk
	FROM user
	WHERE email = mail;
	
	IF id IS NULL OR id = 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_WM";
	ELSE
		IF actif = 0 THEN
			SELECT false AS "erreur";
			SELECT * FROM crypt WHERE token = tk;
			SELECT * FROM errors WHERE code = "ACT_RS";
		ELSE
			SELECT true AS "erreur";
			SELECT * FROM errors WHERE code = "ACT_AA";
		END IF;
	END IF;
END ;

# -----------------------------------------------------------------------------
#       PROCEDURE : password_request()
# -----------------------------------------------------------------------------

CREATE PROCEDURE password_request(mail VARCHAR(128))
BEGIN
	Declare id INTEGER;
	Declare actif INTEGER;
	Declare tk VARCHAR(40);
	SELECT id_u, active,token INTO id,actif,tk
	FROM user
	WHERE email = mail;
	
	IF id IS NULL OR id = 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_WM";
	ELSE
		IF actif = 1 THEN
			SELECT false AS "erreur";
			SELECT tk AS "token";
			SELECT * FROM errors WHERE code = "ACT_RS";
		ELSE
			SELECT true AS "erreur";
			SELECT * FROM errors WHERE code = "LOG_NA";
		END IF;
	END IF;
END ;



# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
#
#       INSERTION DE DONNEES
#
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////
# \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
# /////////////////////////////////////////////////////////////////////////////

# Ajout d'un admin
CALL ajouter_admin("admin", "admin", "admin", "admin@domain.tld","7a53be99a2d39e90884249a0260f753e24033947", "8262216f0c53cd1ebc83e1bb6b84ddce84fe7738", sha1(md5('tokenadministrateur')), "administrateur");

# Erreurs ou code
INSERT INTO errors VALUES("OP_S","Opération réussie","success"),
("OP_F","Opération echouée","error"),
("LOG_WP","Erreur de saisie identidiant/mot de passe","danger"),
("LOG_NA","Votre compte n'est pas encore activé","warning"),
("ACT_WT","Une erreur s'est produite, veuillez recommencer la procédure d'activation","error"),
("ACT_WM","Aucun compte ne correspond à cet email","danger"),
("ACT_MAU","L'adresse email est déjà utilisée","error"),
("ACT_AA","Ce compte est déjà activé","warning"),
("ACT_RS","Mail envoyé","success"),
("ACT_S","Activation réussie","success"),
("CL_NF","Classe inexistante","error"),
("CL_NA","Vous n'avez pas accès à cette classe","error"),
("CL_ND","Cette classe n'est pas encore disponnible","warning"),
("MT_NF","Matière inexistante","error"),
("CR_NF","Cours inexistant","error"),
("CR_PNF","Page non trouvée","error"),
("CR_NOC","Aucun cours disponible","error"),
("USR_DB","Création d'un doublon", "error"),
("DEV_NF","Devoir non trouvé", "error"),
("DEV_NA","Devoir accessible", "error");

# Matieres
INSERT INTO matiere VALUES("","Mathématiques","mathematiques","fa fa-superscript"),
("","SLAM 4","slam-4","fa fa-code"),
("","SLAM 3","slam-3","fa fa-cogs"),
("","Droit","droit","fa fa-gavel"),
("","Français","francais","fa fa-book"),
("","SI7","si7","fa fa-sitemap");

# Ajout automatique de la première session
CALL ajouter_session("2012/2013");
CALL ajouter_session("2013/2014");

# Ajout de section
INSERT INTO section values("",1,"BTS SIO");

# Ajout de classe
INSERT INTO classe VALUES("",1,1,"SIO 1 LM","sio-1-lm"),
("",1,1,"SIO 1 JV","sio-1-jv"),
("",2,1,"SIO 2 LM","sio-2-lm"),
("",2,1,"SIO 2 JV","sio-2-jv");

# Ajout d'un professeur
CALL ajouter_prof( "prof", "prof", "prof@domain.tld", 1);
CALL up_prof(2, "prof", "prof", "prof", "prof@domain.tld", "prof", 1);

# Ajout des élèves
CALL ajouter_eleve("Popowicz", "Mikael", "mikael.popowicz@gmail.com", "1989-10-02");
# CALL ajouter_eleve("Docquier", "Camille", "docquier.camille@gmail.com", "1990-02-06");
UPDATE user SET active = 1;
CALL up_eleve(3, "miko", "Popowicz", "Mikael", "mikael.popowicz@gmail.com", "miko", "1989-10-02");

# Assignation des matières aux classes
INSERT INTO assigner VALUES(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(6,1),
(1,2),
(2,2),
(3,2),
(4,2),
(5,2),
(6,2);

# Assignation de professeur aux classes
INSERT INTO charger VALUES(1,2),
(2,2),
(3,2),
(4,2);

# Assignation d'élève aux classes
INSERT INTO etre VALUES(3,1);
# INSERT INTO etre VALUES(4,1);
/*
# Insertion d'un cours
CALL ajouter_cours(3, 1, 1, "Cours de test", "cours-de-test", "Description du cours de test", "Contenu du cours de test");
CALL up_cours(1, 1, 1, "Cours de test 2", "cours-de-test-2", "Description du cours de test 2", "Contenu du cours de test 2");

# Insertion d'un devoir
CALL ajouter_devoir(2,1,"Devoir de test","Super devoir", "2014-06-30");
*/