<?php
namespace Library\Models;
 
use \Library\Entities\Devoir;



//$dateDevoir,
//$enoncer,
//$dateMax,
//$prof,
//$classe;
 
/**
*	ERREURS :
*	Lorsque l'on va chercher dans la table le nom des colonnes doivent être exactement les nom des attributs de la classe
*	Ici on utilise le mode PDO::FETCH_CLASS => cela permet de récupérer les donnée et PDO s'occupe tout seul de créer les objets
*	d'ailleurs la création d'objets dans ce mode OUTREPASSE completement les règles de nos constructeurs et setters
*	Cela veut dire, que si l'énoncé est obligatoire mais que dans la table il y un devoir sans énoncé
*	alors PDO lui sera capable de créer un objet même si il n'est pas valide
*	Pour cela il faut donc veiller a utiliser des attributs identiques en BDD et dans nos classes et à défaut à UTILISER DES ALIAS dans nos requêtes
*	id_d AS id, id_classe AS classe, etc...
*/
 
 
class DevoirManager_PDO extends DevoirManager
{
	/**
	*	On ne met pas le NOM du proffesseur dans $prof mais l'id_p
	*	Il faut que $enoncer deviennet $ennonce ou que dans la requete tu mettes d.ennonce AS enoncer
	*	ATTENTION AUX REQUETES SQL, surtout au niveau de la jointure !!!!!
	*	On fait une jointure sur le même attribut qui est sur deux tables différentes
	*	Ici la jointure avec le PROFFESSEUR sera INNER JOIN professeur p ON p.id_p = d.id_p
	*	c.id_classe AS matiere ??!!
	*/
	public function getList() //AFFICHE LA LISTE DES DEVOIRS
	{
		$sql = 'SELECT d.id_d as id, p.nom AS prof, c.id_classe AS matiere, d.dateDevoir, d.enonce, d.dateMax,
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_d 
			INNER JOIN classe c ON c.id_classe = d.id_classe
			ORDER BY id_d DESC';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Devoir');
     
		$listeDevoir = $requete->fetchAll();
     
		foreach ($listeDevoir as $devoir)
		{
			$devoir->setDateDevoir(new \DateTime($devoir->dateDevoir()));
			$devoir->setDateMax(new \DateTime($devoir->dateMax()));
		}
     
		$requete->closeCursor();
     
		return $listeDevoir;
	}

	public function getListByTeacher($professeur) //AFFICHE LA LISTE DES DEVOIRS PAR PROF 
	{
		$requete = $this->dao->prepare('SELECT d.id_d as id, p.nom AS prof, c.id_classe AS matiere, d.dateDevoir, d.enonce, d.dateMax,
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_d 
			INNER JOIN classe c ON c.id_classe = d.id_classe
			WHERE p.id_p = :id_p
			ORDER BY dateDevoir DESC');
		$requete->bindValue(':id_p', $professeur);
		$requete->execute();
		
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Devoir');
     
		$listeDevoir = $requete->fetchAll();
     
		foreach ($listeDevoir as $devoir)
		{
			$devoir->setDateDevoir(new \DateTime($devoir->dateDevoir()));
			$devoir->setDateMax(new \DateTime($devoir->dateMax()));
		}
     
		$requete->closeCursor();
     
		return $listeDevoir;
	}
	
	/**
	*	Alors, ici, c'est le pire, tu dis afficher par classe et il y a une clause WHERE sur le libelle du devoir ?
	*	Cela devrait être sur l'id_c l'id de la classe
	*	
	*
	*/
	public function getListOf($classe) //AFFICHE LES DEVOIRS PAR CLASSE
	{
		$requete = $this->dao->prepare('SELECT d.id_d as id, p.nom AS prof, c.id_classe AS matiere, d.dateDevoir, d.enonce, d.dateMax,
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_d 
			INNER JOIN classe c ON c.id_classe = d.id_classe
			WHERE d.libelle = :libelle
			ORDER BY dateDevoir DESC');
		$requete->bindValue(':libelle', $classe, \PDO::PARAM_STR);
		$requete->execute();
		
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\classe');
     
		$listeCours = $requete->fetchAll();
     
		foreach ($listeDevoir as $devoir)
		{
			$devoir->setDateDevoir(new \DateTime($devoir->dateDevoir()));
			$devoir->setDateMax(new \DateTime($devoir->dateMax()));
		}
     
		$requete->closeCursor();
     
		return $listeDevoir;
	}
	
	/**
	*	Cette méthode est inutile dans ce cas la !
	*
	*
	*/
	public function getLast() //AFFICHE LES DEVOIRS PAR DATE MAX DE RENDU (AVEC UNE LIMITE D AFFICHAGE DE 5)
	{
		$requete = $this->dao->prepare('SELECT d.id_d as id, p.nom AS prof, c.id_classe AS matiere, d.dateDevoir, d.enonce, d.dateMax,
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_d 
			INNER JOIN classe c ON c.id_classe = d.id_classe
			ORDER BY dateMax DESC
			LIMIT 5');
			
		$requete->execute();
	
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Devoir');
 
		$listeDevoir = $requete->fetchAll();
 
		foreach ($listeDevoir as $devoir)
		{
			$devoir->setDateDevoir(new \DateTime($devoir->dateDevoir()));
			$devoir->setDateMax(new \DateTime($devoir->dateMax()));
		}
     
		$requete->closeCursor();
     
		return $listeDevoir;
	}
	
	
	/**
	*	Et bien OUI, il faut de temps en temps consulter un devoir unique
	*	Un étudiant doit pouvoir accéder à une page où il a l'énnoncé et la possibilité d'uploader son devoir
	*	Idem le professeur ou administrateur peut consulter cette page, donc on ne récupère que le devoir voulu
	*/
	public function getUnique($id) //AFFICHE LES DEVOIRS PAR ID UNIQUE ??? KÉZAKO??? 
	{
		$requete = $this->dao->prepare('SELECT d.id_d as id, p.nom AS prof, c.id_classe AS matiere, d.dateDevoir, d.enonce, d.dateMax,
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_d 
			INNER JOIN classe c ON c.id_classe = d.id_classe
			WHERE d.id_d = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Devoir');
     
		if ($devoir = $requete->fetch())
		{
			$devoir->setDateDevoir(new \DateTime($devoir->dateDevoir()));
			$devoir->setDateMax(new \DateTime($devoir->dateMax()));
       
			return $devoir;
		}
     
		return null;
	}
	
	/*
	*	dateDevoir est au format DATE et non DATETIME, donc on ne met pas NOW() mais CURDATE()
	*	$devoir->dateMax() renvoi un objet DateTime (php) on ne peut passer un objet, il y a une méthode pour renvoyer la date en STRING
	*	$devoir->dateMax()->format('Y-m-d') => '2014-01-23'
	*/
	protected function add(Devoir $devoir) //AJOUT D'UN DEVOIR
	{
		$requete = $this->dao->prepare('INSERT INTO devoir SET id_p = :prof, id_c = :classe, enonce = :enoncer, dateDevoir = NOW(), dateMax = :dateMax');
		
	    $requete->bindValue(':prof', $devoir->prof());
		$requete->bindValue(':classe', $devoir->classe());
	    $requete->bindValue(':ennoncer', $devoir->ennoncer());
	    $requete->bindValue(':dateMax', $devoir->dateMax());
 
	    $requete->execute();
	}
	
	protected function modify(Devoir $devoir) //MODIFICATION D'UN DEVOIR
	{
	    $requete = $this->dao->prepare('UPDATE devoir SET id_p = :prof, id_c = :classe, enonce = :enoncer, dateDevoir = NOW(), dateMax = :dateMax WHERE id_d = :id');
	    $requete->bindValue(':classe', $devoir['classe']);
		$requete->bindValue(':enoncer', $devoir['enoncer']);
		$requete->bindValue(':dateMax', $devoir['dateMax']);
		$requete->bindValue(':id', $devoir['id']);
	    $requete->execute();
	}
	
  	public function delete(Devoir $devoir) //SUPPRESSION D'UN DEVOIR (PAR L'ID)
  	{
  		$this->dao->exec('DELETE FROM devoir WHERE id_d = '.$devoir['id']);
  	}
	  
	  
}