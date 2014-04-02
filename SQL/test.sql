drop procedure if exists activation;
drop table if exists errors;

#INSERT INTO cours SET id_m = 1, id_classe = 1, id_u = 2, titre = "Arithmétique", description = "Super cours de maths", contenu = "pas encore de contenu", dateAjout = curdate(), dateModif = curdate();

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
 DELETE FROM errors;
INSERT INTO errors VALUES("OP_S","Opération réussie","success"),
("OP_F","Opération echouée","error"),
("LOG_WP","Erreur de saisie identidiant/mot de passe","danger"),
("LOG_NA","Votre compte n'est pas encore activÃ©","warning"),
("ACT_WT","Une erreur s'est produite, veuillez recommencer la procÃ©dure d'activation","error"),
("ACT_AA","Ce compte est dÃ©jà activÃ©","warning"),
("ACT_S","Activation rÃ©ussie","success");

Delimiter @@


# -----------------------------------------------------------------------------
#       PROCEDURE : activation()
# -----------------------------------------------------------------------------

CREATE PROCEDURE activation(oldtk VARCHAR(40), newtk VARCHAR(40))
BEGIN
	Declare id INTEGER;
	Declare actif INTEGER;
	SELECT id_u, active INTO id,actif
	FROM user
	WHERE token = oldtk;
	
	IF id IS NULL OR id = 0 THEN
		SELECT true AS "erreur";
		SELECT * FROM errors WHERE code = "ACT_WT";
	ELSE
		IF actif = 0 THEN
			SELECT false AS "erreur";
			UPDATE user
			SET active = 1,
			token = newtk
			WHERE id_u = id;
			SELECT * FROM errors WHERE code = "ACT_S";
		ELSE
			SELECT true AS "erreur";
			SELECT * FROM errors WHERE code = "ACT_AA";
		END IF;
	END IF;
END @@

Delimiter ;