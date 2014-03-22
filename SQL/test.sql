drop procedure if exists select_cours;
drop procedure if exists select_com;
drop procedure if exists select_cours_com;
drop procedure if exists select_cours_auteur;
drop procedure if exists select_cours_classe_matiere;
drop procedure if exists select_cours_unique_classe_matiere;
drop procedure if exists select_class;

#INSERT INTO cours SET id_m = 1, id_classe = 1, id_u = 2, titre = "Arithmétique", description = "Super cours de maths", contenu = "pas encore de contenu", dateAjout = curdate(), dateModif = curdate();

Delimiter @@

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours(cours INTEGER)
BEGIN
	Declare classe INTEGER;
	Declare id INTEGER;
	DECLARE no_cours CONDITION FOR 1329;
	DECLARE EXIT HANDLER FOR no_cours
	BEGIN
		SELECT "Ce cours n'existe pas" AS "Message";
	END;
	
	# Cours
	SELECT id_cours INTO id
	FROM cours
	WHERE id_cours = cours;
	
	SELECT id_cours AS id, titre, description, contenu, dateAjout, dateModif
	FROM cours
	WHERE id_cours = cours;
	
	# Matière
	SELECT m.id_m AS id, m.libelle
	FROM matiere m
	INNER JOIN cours c ON c.id_m = m.id_m
	WHERE c.id_cours = cours;
	
	# Auteur
	SELECT u.id_u AS id, u.username, u.nom, u.prenom, u.email, u.dateUser
	FROM user u
	INNER JOIN cours c ON c.id_u = u.id_u
	WHERE c.id_cours = cours;
	
	# Classe
	SELECT cl.id_classe INTO classe
	FROM classe cl
	INNER JOIN cours c ON c.id_classe = cl.id_classe
	WHERE c.id_cours = cours;
	CALL select_class(classe);
	
	# Commentaires
	CALL select_cours_com(cours);
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_com()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_com(cours INTEGER)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare user INTEGER;
	Declare dateCom DATETIME;
	
	# Curseur
	Declare cur1 CURSOR
	FOR SELECT id_u, dateCommentaire
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
	FETCH cur1 INTO user,dateCom;
	WHILE fini != 1	DO
		CALL select_com(user,cours,dateCom);
		FETCH cur1 INTO user,dateCom;
	END WHILE;
	Close cur1;
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : select_comm()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_com(user INTEGER, cours INTEGER, dateComm DATETIME)
BEGIN
	# Commentaire
	SELECT id_cours AS cours, dateCommentaire, commentaire
	FROM commenter
	WHERE id_cours = cours
	AND id_u = user
	AND dateCommentaire = dateComm;
	
	# Auteur
	SELECT id_u AS id, username, nom, prenom, email, dateUser
	FROM user
	WHERE id_u = user;
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_auteur()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_auteur(user INTEGER)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare id INTEGER;
	
	# Curseur
	Declare cur1 CURSOR
	FOR SELECT c.id_cours
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
	FETCH cur1 INTO id;
	WHILE fini != 1	DO
		CALL select_cours(id);
		FETCH cur1 INTO id;
	END WHILE;
	Close cur1;
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_unique_classe_matiere()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_unique_classe_matiere(cours VARCHAR(1024), classe INTEGER, matiere INTEGER)
BEGIN
	# Déclaration
	Declare id INTEGER;
	Declare no_cours CONDITION FOR 1329;
	Declare EXIT HANDLER FOR no_cours
	BEGIN
		SELECT true AS "erreur";
		SELECT "Cours inexistant" AS "Message";
	END;
	
	SELECT id_cours INTO id
	FROM cours
	WHERE id_classe = classe
	AND id_m = matiere
	AND titre = cours;
	
	SELECT false AS "erreur";
	
	CALL select_cours(id);
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : select_cours_classe_matiere()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_cours_classe_matiere(classe INTEGER, matiere INTEGER)
BEGIN
	# Déclaration
	Declare fini int default 0;
	Declare id INTEGER;
	
	# Curseur
	Declare cur1 CURSOR
	FOR SELECT c.id_cours
		FROM cours c
		WHERE id_classe = classe
		AND id_m = matiere;
		
	# Gestionnaire d'erreur
	Declare continue HANDLER
		FOR NOT FOUND SET fini = 1;
	
	# Nombre de cours
	SELECT COUNT(*) AS "Cours"
	FROM cours
	WHERE id_classe = classe
	AND id_m = matiere;
	
	# Ouverture du curseur
	Open cur1;
	FETCH cur1 INTO id;
	WHILE fini != 1	DO
		CALL select_cours(id);
		FETCH cur1 INTO id;
	END WHILE;
	Close cur1;
END @@

# -----------------------------------------------------------------------------
#       PROCEDURE : select_class()
# -----------------------------------------------------------------------------

CREATE PROCEDURE select_class(classe INTEGER)
BEGIN
	SELECT id_classe AS id, libelle
	FROM classe
	WHERE id_classe = classe;
	
	SELECT s.id_session AS id, s.session
	FROM session s
	INNER JOIN classe c ON s.id_session = c.id_session
	WHERE c.id_classe = classe;
	
	SELECT s.id_section AS id, s.id_u AS admin, s.libelle
	FROM section s
	INNER JOIN classe c ON s.id_section = c.id_section
	WHERE c.id_classe = classe;
	
	SELECT m.id_m AS id, m.libelle, m.icon
	FROM matiere m
	INNER JOIN assigner a ON m.id_m = a.id_m
	WHERE a.id_classe = classe
	ORDER BY m.libelle;
	
	SELECT u.id_u AS id, u.nom, u.prenom
	FROM user u
	INNER JOIN charger c ON u.id_u = c.id_u
	INNER JOIN professeur p ON u.id_u = p.id_u
	WHERE c.id_classe = classe;
	
	SELECT u.id_u AS id, u.nom, u.prenom
	FROM user u
	INNER JOIN etre e ON u.id_u = e.id_u
	INNER JOIN eleve p ON u.id_u = p.id_u
	WHERE e.id_classe = classe;
END @@

Delimiter ;