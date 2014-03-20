drop procedure if exists select_class_by_name;
drop procedure if exists select_class_session_user;



# -----------------------------------------------------------------------------
#       PROCEDURE : select_class_session_user()
# -----------------------------------------------------------------------------
DELIMITER @@

CREATE PROCEDURE select_class_session_user(classe VARCHAR(128), session VARCHAR(128), user INTEGER)
BEGIN
	Declare id INTEGER;
	Declare lib VARCHAR(128);
	DECLARE no_class CONDITION FOR 1329;
	DECLARE EXIT HANDLER FOR no_class
	BEGIN
		SELECT true AS "erreur";
		SELECT "Cette classe n'existe pas" AS "Message";
	END;
	SELECT c.id_classe AS id, c.libelle INTO id,lib
	FROM classe c
	INNER JOIN session s ON c.id_session = s.id_session
	WHERE c.libelle = classe
	AND s.session = session;
	IF (SELECT COUNT(*)
		FROM classe c
		INNER JOIN etre e ON e.id_classe = c.id_classe
		WHERE c.id_classe = id
		AND e.id_u = user) > 0 THEN	
		IF (MONTH(CURDATE()) < 8 AND SUBSTR(session,1,4) < YEAR(CURDATE())) OR (MONTH(CURDATE()) > 8 AND SUBSTR(session,1,4) <= YEAR(CURDATE())) THEN
			SELECT false AS "erreur";
			CALL select_class(id);
		ELSE
			SELECT true AS "erreur";
			SELECT "On ne peut prÃ©dire l'avenir" AS "Message";
		END IF;
	ELSE
		SELECT true AS "erreur";
		SELECT "Vous ne pouvez accÃ©der Ã cette classe" AS "Message";
	END IF;
END @@

Delimiter ;