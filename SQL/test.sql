drop function if exists keygen;
drop procedure if exists ajouter_eleve;

DELIMITER @@

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
END @@

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
		SET id = (SELECT autoincrement());
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
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : up_eleve()
# -----------------------------------------------------------------------------

CREATE PROCEDURE up_eleve(id INTEGER, a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), a_active BOOLEAN, a_salt VARCHAR(40), a_token VARCHAR(40), a_dateNaissance DATE)
BEGIN
	Declare surname VARCHAR(128);
	Declare it INTEGER DEFAULT 0;
	Declare test BOOLEAN true;
	
	IF (SELECT COUNT(*) FROM user WHERE email = a_email AND id_u != id) > 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_MAU";
	ELSE
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
		UPDATE user SET
	    username = surname,
	    nom = a_nom,
	    prenom = a_prenom,
	    email = a_email,
	    password = a_pass,
	    active = a_active,
	    salt = a_salt,
	    token = a_token
	    WHERE id_u = id;
	    UPDATE eleve SET
	    dateNaissance = a_dateNaissance
	    WHERE id_u = id;
	END IF;
  
END @@

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
		SET id = (SELECT autoincrement());
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
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : up_prof()
# -----------------------------------------------------------------------------

CREATE PROCEDURE up_prof(id INTEGER, a_nom VARCHAR(128), a_prenom VARCHAR(128), a_email VARCHAR(128), a_pass VARCHAR(128), a_active BOOLEAN, a_salt VARCHAR(40), a_token VARCHAR(40), matiere INTEGER(2))
BEGIN
	Declare surname VARCHAR(128);
	Declare it INTEGER DEFAULT 0;
	Declare test BOOLEAN true;

	IF (SELECT COUNT(*) FROM user WHERE email = a_email AND id_u != id) > 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_MAU";
	ELSE
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
		UPDATE user SET
		username = surname,
		nom = a_nom,
		prenom = a_prenom,
		email = a_email,
		password = a_pass,
		active = a_active,
		salt = a_salt,
		token = a_token
		WHERE id_u = id;
		UPDATE professeur SET
		id_m = matiere
		WHERE id_u = id;
	END IF;
END @@

DELIMITER ;