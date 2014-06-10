DROP PROCEDURE if exists connexion;

# -----------------------------------------------------------------------------
#       PROCEDURE : log()
# -----------------------------------------------------------------------------

Create table IF not exists log
(
id_connexion INTEGER not null Auto_increment,
id_u INTEGER,
date_conn DATETIME not null,
etat_conn VARCHAR(15) not null,
PRIMARY KEY (id_connexion)
);

Delimiter @@
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
	Insert into log 
	set id_u=0,date_conn=sysdate(),etat_conn="erreur de login";
		SELECT true AS "erreur";
		SELECT "Erreur de saisie identidiant/mot de passe" AS "Message", "danger" AS "Type";
	END;
	
	SELECT id_u, salt INTO id,sel
	FROM user
	WHERE username = login;

	SET passwd = SHA1(MD5(CONCAT(SHA1(MD5(sel)),SHA1(pass),SHA1(MD5(sel)))));
	
	IF (SELECT COUNT(*) FROM user WHERE username = login AND password = passwd) > 0 THEN
		SELECT id_u,username,nom,prenom,email,password,active,salt,token,dateUser INTO id,user,name,last,mail,passwd,actif,sel,tok,dateU
		FROM user
		WHERE username = login AND password = passwd;
		IF actif THEN
		Insert into log 
		set id_u=id,date_conn=sysdate(),etat_conn="connexion reussie";
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
		Insert into log 
		set id_u=id,date_conn=sysdate(),etat_conn="compte pas activé";
			SELECT true AS "erreur";
			SELECT "Votre compte n'est pas encore activÃ©" AS "Message", "warning" AS "Type";
		END IF;
	ELSE
	Insert into log 
	set id_u=id,date_conn=sysdate(),etat_conn="probleme de mot de passe ";
		SELECT true AS "erreur";
		SELECT "Erreur de saisie identidiant/mot de passe" AS "Message", "danger" AS "Type";
	END IF;
END @@

Delimiter ; 
