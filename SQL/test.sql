drop procedure if exists select_matiere_cours;

DELIMITER @@

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
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	# Nombre de cours
	IF class IS NULL OR class = 0 THEN
		SELECT COUNT(*) AS "Cours_1" FROM cours WHERE id_m = mat;
		Open cur1;
		FETCH cur1 INTO id;
		WHILE fini != 1	DO
			CALL select_cours(id, false);
			FETCH cur1 INTO id;
		END WHILE;
		Close cur1;
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
END @@

DELIMITER ;