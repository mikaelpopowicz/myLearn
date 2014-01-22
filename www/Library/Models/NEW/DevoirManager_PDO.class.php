<?php
namespace Library\Models;
 
use \Library\Entities\Devoir;



//$dateDevoir,
//$enoncer,
//$dateMax,
//$prof,
//$classe;
 
class DevoirManager_PDO extends DevoirManager
{
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