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
   id_m INTEGER(2) NOT NULL  ,
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
   id_classe INTEGER(2) NOT NULL  ,
   dateNaissance DATE NOT NULL
   , PRIMARY KEY (id_u) 
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
   id_section INTEGER(2) NOT NULL  ,
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
#       TABLE : classe
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS classe
 (
   id_classe INTEGER(2) NOT NULL  ,
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
  ADD FOREIGN KEY FK_eleve_classe (id_classe)
      REFERENCES classe (id_classe) ;


ALTER TABLE eleve 
  ADD FOREIGN KEY FK_eleve_user (id_u)
      REFERENCES user (id_u) ;


ALTER TABLE section 
  ADD FOREIGN KEY FK_section_administrateur (id_u)
      REFERENCES administrateur (id_u) ;


ALTER TABLE gestionnaire 
  ADD FOREIGN KEY FK_gestionnaire_user (id_u)
      REFERENCES user (id_u) ;


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

INSERT INTO user (id_u, username, salt, password, active, dateUser, token) VALUES(1, 'admin', '8262216f0c53cd1ebc83e1bb6b84ddce84fe7738', '7a53be99a2d39e90884249a0260f753e24033947', 1, CURDATE(), sha1(md5('tokenadministrateur')));
INSERT INTO administrateur VALUES(1);