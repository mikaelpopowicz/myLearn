-- MySQL dump 10.13  Distrib 5.5.33, for osx10.6 (i386)
--
-- Host: localhost    Database: mylearn
-- ------------------------------------------------------
-- Server version	5.5.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrateur` (
  `id_u` int(2) NOT NULL,
  `poste` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_u`),
  CONSTRAINT `administrateur_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `user` (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrateur`
--

LOCK TABLES `administrateur` WRITE;
/*!40000 ALTER TABLE `administrateur` DISABLE KEYS */;
INSERT INTO `administrateur` VALUES (1,'administrateur');
/*!40000 ALTER TABLE `administrateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER del_admin
AFTER DELETE ON administrateur
FOR EACH ROW
BEGIN
  DELETE FROM user
  WHERE id_u = old.id_u;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `assigner`
--

DROP TABLE IF EXISTS `assigner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assigner` (
  `id_m` int(2) NOT NULL,
  `id_classe` int(2) NOT NULL,
  PRIMARY KEY (`id_m`,`id_classe`),
  KEY `FK_assigner_classe` (`id_classe`),
  CONSTRAINT `assigner_ibfk_1` FOREIGN KEY (`id_m`) REFERENCES `matiere` (`id_m`) ON DELETE CASCADE,
  CONSTRAINT `assigner_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigner`
--

LOCK TABLES `assigner` WRITE;
/*!40000 ALTER TABLE `assigner` DISABLE KEYS */;
/*!40000 ALTER TABLE `assigner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avoir`
--

DROP TABLE IF EXISTS `avoir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avoir` (
  `id_d` int(2) NOT NULL,
  `id_u` int(2) NOT NULL,
  `dateRendu` date DEFAULT NULL,
  `note` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_d`,`id_u`),
  KEY `FK_avoir_eleve` (`id_u`),
  CONSTRAINT `avoir_ibfk_1` FOREIGN KEY (`id_d`) REFERENCES `devoir` (`id_d`) ON DELETE CASCADE,
  CONSTRAINT `avoir_ibfk_2` FOREIGN KEY (`id_u`) REFERENCES `eleve` (`id_u`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avoir`
--

LOCK TABLES `avoir` WRITE;
/*!40000 ALTER TABLE `avoir` DISABLE KEYS */;
/*!40000 ALTER TABLE `avoir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `charger`
--

DROP TABLE IF EXISTS `charger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charger` (
  `id_classe` int(11) NOT NULL,
  `id_u` int(11) NOT NULL,
  PRIMARY KEY (`id_classe`,`id_u`),
  KEY `FK_charger_professeur` (`id_u`),
  CONSTRAINT `charger_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  CONSTRAINT `charger_ibfk_2` FOREIGN KEY (`id_u`) REFERENCES `professeur` (`id_u`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `charger`
--

LOCK TABLES `charger` WRITE;
/*!40000 ALTER TABLE `charger` DISABLE KEYS */;
/*!40000 ALTER TABLE `charger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classe`
--

DROP TABLE IF EXISTS `classe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classe` (
  `id_classe` int(2) NOT NULL AUTO_INCREMENT,
  `id_session` int(11) NOT NULL,
  `id_section` int(2) NOT NULL,
  `libelle` varchar(128) NOT NULL,
  PRIMARY KEY (`id_classe`),
  KEY `FK_classe_session` (`id_session`),
  KEY `FK_classe_section` (`id_section`),
  CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`) ON DELETE CASCADE,
  CONSTRAINT `classe_ibfk_2` FOREIGN KEY (`id_section`) REFERENCES `section` (`id_section`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classe`
--

LOCK TABLES `classe` WRITE;
/*!40000 ALTER TABLE `classe` DISABLE KEYS */;
INSERT INTO `classe` VALUES (1,2,1,'SIO 2 LM'),(2,2,1,'SIO 2 JV');
/*!40000 ALTER TABLE `classe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commenter`
--

DROP TABLE IF EXISTS `commenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commenter` (
  `id_u` int(2) NOT NULL,
  `id_cours` int(2) NOT NULL,
  `dateCommentaire` datetime NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id_u`,`id_cours`,`dateCommentaire`),
  KEY `FK_commenter_cours` (`id_cours`),
  CONSTRAINT `commenter_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `user` (`id_u`) ON DELETE CASCADE,
  CONSTRAINT `commenter_ibfk_2` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commenter`
--

LOCK TABLES `commenter` WRITE;
/*!40000 ALTER TABLE `commenter` DISABLE KEYS */;
/*!40000 ALTER TABLE `commenter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cours` (
  `id_cours` int(2) NOT NULL,
  `id_m` int(2) NOT NULL,
  `id_classe` int(2) NOT NULL,
  `id_u` int(2) NOT NULL,
  `titre` varchar(128) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `contenu` text,
  `dateAjout` datetime DEFAULT NULL,
  `dateModif` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cours`),
  KEY `FK_cours_matiere` (`id_m`),
  KEY `FK_cours_classe` (`id_classe`),
  KEY `FK_cours_user` (`id_u`),
  CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`id_m`) REFERENCES `matiere` (`id_m`),
  CONSTRAINT `cours_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`id_u`) REFERENCES `user` (`id_u`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours`
--

LOCK TABLES `cours` WRITE;
/*!40000 ALTER TABLE `cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `cours` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER version_cours
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `crypt`
--

DROP TABLE IF EXISTS `crypt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crypt` (
  `token` varchar(40) NOT NULL,
  `message` varchar(1024) DEFAULT NULL,
  `cle` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crypt`
--

LOCK TABLES `crypt` WRITE;
/*!40000 ALTER TABLE `crypt` DISABLE KEYS */;
INSERT INTO `crypt` VALUES ('6WxkHGlse29XqfNamxT4YnzhV13tO96VFI92ReMb','OcZsnBtUyP9ze2XNm81opuv1mvxxpLb6CCk2hwfD9KS+m90qUNFt/tdIyrIkBG+8VYUlY8Tql66BCwLBR5In0alG7PkMEg8uekHn+fRtcmYt2HZyINMDod5TtjHhGqaj6gSgXAa2rmIEJbTnsc3A9a/o0mI0TV9UQFPSWZsZMBWISmE174ljP12xv52F3YjwVnTnj393CZigIHiWyO4506voqx5jexcu5uZ5aRiThv81jx4H0taVTvZcnkubKHVvuc/2ZP6FJ8wWo0A7OliVXXE661fG7YvQzuu94QVfSn3+ibdj3uRykLfzCkfIRx24dUkZupAY1EpOyDZKZXhSQxPc07MSTLqpBGyd0vCRwZdOxaX7O+0L2bYFXcuj5blHwl+wLZuwNj0Cz5Vk4IjpJrSucZzQTZVETfAhkJq8rwcYlXG4mMzP6qANLueKY4W9LkMk4DG7+63JPhy3wT9rGjhePPdKFeEdkIhHpB8hDN6YwzaVaE5mcIgCAhhekLPpp3rT3kpiXYe0VR/0sGkcYNNZLRpbfVwPIxdrUsEAG9W6V4gs0yCDPSwuRbc1kxA4AOZeDqj6xkBJJs5BxTRQXpgmrUQGIJnKIXMOcXZPROZLB9Nuu8plTxFqJjvkE/dWk7ZHu3pY+Y5zJ+nyKDJsGmaK7DpIyRipQi0+91RT/Z2fg0n+KJS8k3YZ5iUA7GNFP7IPobb8l+lY+Z4TKCZ+LZg7fov2SfZ1N4C8TWkWt4huXn6YF6cFk7LPsyEGhg==','ZTc2aXZrQTc5TjR4REZ4OTd0VEVDcWJW'),('aG3FOIohm391DMghFbkF7ZPSdA1ZKdQcO9kbRzRI','cfY7QUXr67tqCM2SCC8V2v6lCOXEhgAVob72l9w7k5KG/XM2VuMQWMDFsWbzf74fuGCyThzWVySlYPzFF5e/ZrDW5baHW4xDp8Qv8F9Jr+1jxVLPosBiH96qOxAHB/rsql07hrAdrQ9bxlM0JI1+7wUXpOWUkqH+uBCLH26rLIr9r0wF8cyzSOJ0xdDlNE6bFGpZfFrqhnzJMxEppWgR+ZFMrPmh07QRT8cUSP2PqMZuYUwsARmfpFtunsq9L39722kH+yvStnxnrZN9mHvZ/Dc90cNHTs3HO9aiR3bsdAin4QsIh/SsVP7tqeb2bbtnP6XCQLvHGoAPgOuFbUWdlcJXviX+XkHCkRO/w6XT0Q26AkRK4xp5NR61POF5gKlGOsb0hQ5Dwh/rFfxzLbidMSgsngyqwLn1MEZB2rUia1lptnepLdS7B3cLukb79U42V1RA9yf3cSdY4IPUEZINVcMOsd8ARtH1VlKHzMbYaR0xR1Ebv/uAQldLqi+jZkSpF/6Gx80Uj26IwmuKd0l4fHg7VHGFUJE9cE1ijl7gQU/n8BF2eUGiGDg91LUqJkwFa1ijU7X1OL68Wkhl42TBXqNzAobxXnlFfFeXGBi+hyfaCiIs4XhSCvdKwLSxeawkb1b866mKSDep9/yn44Q9ozdWJucsE6zL07f1QBhtqnEZO9DPsmGPMf1yz9pnx7dT8B8kY2eLmuVquC56qyyd/u6YAbdToNJlhPvQIABQbrvUNxKW56oIrgKFI8kl+yDM6E8dhEM3','WFJwOWVvQm42MnpMU3pFZ0VpaFNvZlpZ'),('J7gjzta0xsUt6m0Gb2qrMV6ty7uqYenHNkbtHgQZ','+F26cZdHx3SDbCGc3GlZ1pwh6KBUQWV6057kyqts9GGXafeY2XT6Ahqzz1bEcXV+w6gMdapg1DQvMMWpMAe4TmpQWYogyh4vgc8rcr5gW18tDuiQ/5FBxG2S+NnTG5o94qdOLv4tzcZV0yOKzXnyx7f5sm3Xbf1+sWmlZuiaWLvm94jwd/lJ62r6Hw2t9kLDOboDIij4Z8cnSKsi3KcAoRw6kOmoAtryLjbaXy31RbNJ1TqRkFs3ORjG4CS24qG+JpjzhwkG0QSpW2ytaHX3CEv2xyCqzDYFFRnaC4h9C2O4s3gxobB0gYT7YXOW09poNErp/W9cxYL4aL7Q8IIJIfP/xQLUHEUYQaA39Tkfrzp9MHDJP/NyUXzlI+G12E1Eq0xsrN8cI6z71tpiakzpsMhSeCjqSlJ75aCgKSqJimWP6zIJY2lsV/r8755mAjWDoHzff3nFzLbH7vqIEDKQorgFnf7HNxvTVdi1VWtRxa5ZpnFIP8d+dLWo91uy7gAoc4U5RcEcau5A0RLTC74KYx8GVICzspw3/RHeyYzuURA2weyMCFHB8vMMDIR7YOaqER2Dk75UUoDvfraKwf+M2nFj5P3mAGXI3uGt7n3x//0GpCrXgdvoE8Uzm0tCJPq6lNaVZ/WX4Fkmt9+BAetnEB1k/m+X2B1zhOCOt0x7nZTp5UGvyo1oN3xCpnNGBwwWHkciJMlX05T3U/MYZImgozXBT0Mp8QiIlV/49dzP0rJmWp0eEGW8xu6BIKufHGBeP/FA/w==','bGYxVllOUXF6cHdhdUdKYlpPU3dUNGxV'),('QXiLvBoLhWoTiKDuLa9IfDObD7nWgagssqOZSNBL','s6E30pkQatikcw25/lUcTZIyr0MLuc3Q0Bpl/DrU+2l2Y5Lun37eM6zXeAm9g1wERZUTfBpqW7KF45lwAo/w9XO8lOIv9vedln0l6EzPUbJFKq1oSMDOAW9GyA5YnhpGcG7+9eM1sbr/C/2PO+VLnvVE3+xcahkwYChyT7thG31XQxM0dyGF12mflkaNBOY6ykoNlCHF1zrd8hLo5yzkMqItgZuWqyg2fY0nMLRh3VGoCoI2WksQI2iLlWa48Xm4VhxBRZAzc48UMucuuEXs3RDJS9RNpQW2DLYaFOHvJDjOzmkRtKvtnzOj6Bq8EJ1aUEU8pqaEdd80JpTyDhxwKNrEoRoikm5EAaWWz8SquHccsYLtUB+KDXcbz4sgsIUesXnZfj169uhUyRl0JhEERJ2eRAulT6LkGtAAkSAtgQ7gC2NY0UzCVCk7H3XKHANwvNHjfaoVELDboY8MxoLdfdfZeIsc6HjzeqbY4YebZZQ60IVjiOpNsArSH6wWftSFON6rmZZZh9eEJ4M/N97r1VHEveQIIL37hSms86ggv9uOCQUXo0eAuGsI+mAb20uItIR5IQo9bT7QMnMd7B0UVl0gcGam7MRlC5Xt9zqj46f/EzTNT8+uQEngzSo6QKsjtei6GjNeG47/toMBdw4/PHPUuDSZq9yNDJI3oWqnBRk8OvwY6yveWd1StM51sDKljimMBt4mQkTDkxfaZS8QDHyiL6nRmyePFXz9VKJP+vCXLajMonk+Kj+Fs8jg8QuZdKWPfD4=','bEl1WjZNZ3ZaelZvZXhTamp4Sks0WGJp');
/*!40000 ALTER TABLE `crypt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devoir`
--

DROP TABLE IF EXISTS `devoir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devoir` (
  `id_d` int(2) NOT NULL,
  `id_u` int(2) NOT NULL,
  `id_classe` int(2) NOT NULL,
  `dateDevoir` date DEFAULT NULL,
  `enonce` varchar(128) DEFAULT NULL,
  `dateMax` date DEFAULT NULL,
  PRIMARY KEY (`id_d`),
  KEY `FK_devoir_professeur` (`id_u`),
  KEY `FK_devoir_classe` (`id_classe`),
  CONSTRAINT `devoir_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `professeur` (`id_u`) ON DELETE CASCADE,
  CONSTRAINT `devoir_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devoir`
--

LOCK TABLES `devoir` WRITE;
/*!40000 ALTER TABLE `devoir` DISABLE KEYS */;
/*!40000 ALTER TABLE `devoir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eleve` (
  `id_u` int(2) NOT NULL,
  `dateNaissance` date NOT NULL,
  PRIMARY KEY (`id_u`),
  CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `user` (`id_u`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eleve`
--

LOCK TABLES `eleve` WRITE;
/*!40000 ALTER TABLE `eleve` DISABLE KEYS */;
INSERT INTO `eleve` VALUES (2,'1990-02-06'),(4,'0000-00-00'),(5,'0000-00-00'),(6,'1992-03-01');
/*!40000 ALTER TABLE `eleve` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER del_el
AFTER DELETE ON eleve
FOR EACH ROW
BEGIN
  DELETE FROM user
  WHERE id_u = old.id_u;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `etre`
--

DROP TABLE IF EXISTS `etre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etre` (
  `id_u` int(2) NOT NULL,
  `id_classe` int(2) NOT NULL,
  PRIMARY KEY (`id_u`,`id_classe`),
  KEY `FK_etre_classe` (`id_classe`),
  CONSTRAINT `etre_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `eleve` (`id_u`) ON DELETE CASCADE,
  CONSTRAINT `etre_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etre`
--

LOCK TABLES `etre` WRITE;
/*!40000 ALTER TABLE `etre` DISABLE KEYS */;
INSERT INTO `etre` VALUES (2,1),(4,1),(6,1);
/*!40000 ALTER TABLE `etre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gerer`
--

DROP TABLE IF EXISTS `gerer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gerer` (
  `id_u` int(2) NOT NULL,
  `id_classe` int(2) NOT NULL,
  PRIMARY KEY (`id_u`),
  KEY `FK_gerer_classe` (`id_classe`),
  CONSTRAINT `gerer_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `gestionnaire` (`id_u`) ON DELETE CASCADE,
  CONSTRAINT `gerer_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gerer`
--

LOCK TABLES `gerer` WRITE;
/*!40000 ALTER TABLE `gerer` DISABLE KEYS */;
/*!40000 ALTER TABLE `gerer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestionnaire`
--

DROP TABLE IF EXISTS `gestionnaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gestionnaire` (
  `id_u` int(2) NOT NULL,
  PRIMARY KEY (`id_u`),
  CONSTRAINT `gestionnaire_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `user` (`id_u`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestionnaire`
--

LOCK TABLES `gestionnaire` WRITE;
/*!40000 ALTER TABLE `gestionnaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `gestionnaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histo_cours`
--

DROP TABLE IF EXISTS `histo_cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `histo_cours` (
  `id_cours` int(2) NOT NULL,
  `id_m` int(2) NOT NULL,
  `id_classe` int(2) NOT NULL,
  `id_u` int(2) NOT NULL,
  `titre` varchar(128) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `contenu` text,
  `dateAjout` datetime DEFAULT NULL,
  `dateModif` datetime DEFAULT NULL,
  `dateHisto` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cours`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histo_cours`
--

LOCK TABLES `histo_cours` WRITE;
/*!40000 ALTER TABLE `histo_cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `histo_cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matiere` (
  `id_m` int(2) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(128) DEFAULT NULL,
  `icon` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_m`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matiere`
--

LOCK TABLES `matiere` WRITE;
/*!40000 ALTER TABLE `matiere` DISABLE KEYS */;
INSERT INTO `matiere` VALUES (2,'SLAM 3','fa fa-signal');
/*!40000 ALTER TABLE `matiere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professeur` (
  `id_u` int(2) NOT NULL,
  `id_m` int(2) NOT NULL,
  PRIMARY KEY (`id_u`),
  KEY `FK_professeur_matiere` (`id_m`),
  CONSTRAINT `professeur_ibfk_1` FOREIGN KEY (`id_m`) REFERENCES `matiere` (`id_m`),
  CONSTRAINT `professeur_ibfk_2` FOREIGN KEY (`id_u`) REFERENCES `user` (`id_u`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professeur`
--

LOCK TABLES `professeur` WRITE;
/*!40000 ALTER TABLE `professeur` DISABLE KEYS */;
INSERT INTO `professeur` VALUES (3,2);
/*!40000 ALTER TABLE `professeur` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER del_prof
AFTER DELETE ON professeur
FOR EACH ROW
BEGIN
  DELETE FROM user
  WHERE id_u = old.id_u;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `section` (
  `id_section` int(2) NOT NULL AUTO_INCREMENT,
  `id_u` int(2) NOT NULL,
  `libelle` varchar(128) NOT NULL,
  PRIMARY KEY (`id_section`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` VALUES (1,1,'BTS SIO');
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(128) NOT NULL,
  PRIMARY KEY (`id_session`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES (2,'2013/2014');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_u` int(2) NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `prenom` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `dateUser` date DEFAULT NULL,
  PRIMARY KEY (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin','admin','admin@domain.tld','7a53be99a2d39e90884249a0260f753e24033947',1,'8262216f0c53cd1ebc83e1bb6b84ddce84fe7738','24d0bbc223176ccf73ad37b0fa311056a4d2cf8f','2014-03-04'),(2,'docqui','docquier','Camille','docquier.camille@gmail.com','f4f3788cf908a400651a00a5d62f5cab42dc94c0',1,'FI6pcmNnBaKA1yMaPpbLZV4xiPY3wNX1sXnpz0CH','DNikSCIWd1mLfW5jui4WSuGoyGqGr9AN1xJiIP2W','2014-03-05'),(3,'tata','Toto','titi','mikael.popowicz@gmail.com','3f79242a281c7479a0e76eb5ad66f1d0233f1e57',0,'0lly326mhcWi6EIM3PadhabHX1shnPNIFQzbU1ns','6WxkHGlse29XqfNamxT4YnzhV13tO96VFI92ReMb','2014-03-05'),(4,'miko','Popowicz','Mikael','mikael.popowicz@gmail.com','eeb71f0a5029db56665a9baad2ee5669cc5d5eac',0,'k3SQXnqbEFPOGCpralReqMCNG2zflczihkDhSxT8','J7gjzta0xsUt6m0Gb2qrMV6ty7uqYenHNkbtHgQZ','2014-03-06'),(5,'amenebhi','Menebhi','Adam','adam.menebhi@gmail.com','2d70aa31327b6cb1d09240fa32b42d518650f750',0,'X3o1EWeHH6UgI3XpJBjDMDjIH6aKZGlSAaECbDnO','QXiLvBoLhWoTiKDuLa9IfDObD7nWgagssqOZSNBL','2014-03-06'),(6,'yyougil','Yougil','Youssef','y.yougil@gmail.com','c71cc5205ace2a634a2a429acc0ed77d972d67fd',0,'CvfMn9lI0oIJLAoXVBKIpKslSuSOMq2aee8r4FEK','aG3FOIohm391DMghFbkF7ZPSdA1ZKdQcO9kbRzRI','2014-03-10');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER up_user
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
  IF old.token != new.token AND old.active = 0 AND new.active = 1
  THEN
    DELETE FROM crypt WHERE token = old.token;
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER del_user
BEFORE DELETE ON user
FOR EACH ROW
BEGIN
  IF old.active = 0 AND (SELECT COUNT(*) FROM crypt WHERE token = old.token) > 0
  THEN
    DELETE FROM crypt WHERE token = old.token;
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `vers_cours`
--

DROP TABLE IF EXISTS `vers_cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vers_cours` (
  `id_cours` int(2) NOT NULL,
  `titre` varchar(128) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `contenu` text,
  `dateModif` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_cours`,`dateModif`),
  CONSTRAINT `vers_cours_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vers_cours`
--

LOCK TABLES `vers_cours` WRITE;
/*!40000 ALTER TABLE `vers_cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `vers_cours` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-11 10:58:19
