drop procedure if exists search_engine;

DELIMITER @@

# -----------------------------------------------------------------------------
#       PROCEDURE : search_engine()
# -----------------------------------------------------------------------------

CREATE PROCEDURE search_engine(chaine TEXT)
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
	SET query = 'SELECT id_cours FROM cours WHERE ';
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
	SET query = CONCAT(query, 'titre LIKE ',clause, ' OR description LIKE ',clause, ' OR contenu LIKE ',clause, ' ORDER BY dateAjout DESC');
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
END @@


DELIMITER ;