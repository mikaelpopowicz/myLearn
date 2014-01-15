<?php
namespace Library\Models;
 
use \Library\Entities\Cours;
 
class CoursManager_PDO extends CoursManager
{
	public function getList()
	{
		$sql = 'SELECT c.id_c as id, b.username AS auteur, c.id_m AS matiere, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
			INNER JOIN byte b ON c.id_u = b.id_u
			ORDER BY id_c DESC';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
     
		$listeCours = $requete->fetchAll();
     
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
     
		$requete->closeCursor();
     
		return $listeCours;
	}

	public function getListByAuthor($byte)
	{
		$requete = $this->dao->prepare('SELECT c.id_c AS id, b.username AS auteur, m.libelle as matiere, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
			INNER JOIN byte b ON c.id_u = b.id_u
			INNER JOIN matiere m ON c.id_m = m.id_m
			WHERE b.id_u = :id_u
			ORDER BY dateAjout DESC');
		$requete->bindValue(':id_u', $byte);
		$requete->execute();
		
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
     
		$listeCours = $requete->fetchAll();
     
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
     
		$requete->closeCursor();
     
		return $listeCours;
	}
	
	public function getListOf($matiere)
	{
		$requete = $this->dao->prepare('SELECT c.id_c AS id, b.username AS auteur, c.id_m as matiere, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
			INNER JOIN byte b ON c.id_u = b.id_u
			INNER JOIN matiere m ON c.id_m = m.id_m
			WHERE m.libelle = :libelle
			ORDER BY dateAjout DESC');
		$requete->bindValue(':libelle', $matiere, \PDO::PARAM_STR);
		$requete->execute();
		
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
     
		$listeCours = $requete->fetchAll();
     
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
     
		$requete->closeCursor();
     
		return $listeCours;
	}
	
	public function getLast() {
		$requete = $this->dao->prepare('SELECT c.id_c AS id, c.id_m AS matiere, b.username AS auteur, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
		 	INNER JOIN byte b ON c.id_u = b.id_u
			INNER JOIN matiere m ON c.id_m = m.id_m
			ORDER BY dateModif DESC
			LIMIT 5');
			
		$requete->execute();
	
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
 
		$listeCours = $requete->fetchAll();
 
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
 
		$requete->closeCursor();
 
		return $listeCours;
	}
	
	public function getPopular() {
		$requete = $this->dao->prepare('SELECT c.id_c AS id, c.id_m AS matiere, b.username AS auteur, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
		 	INNER JOIN byte b ON c.id_u = b.id_u
			INNER JOIN matiere m ON c.id_m = m.id_m
			ORDER BY count_c DESC
			LIMIT 5');
			
		$requete->execute();
	
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
 
		$listeCours = $requete->fetchAll();
 
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
 
		$requete->closeCursor();
 
		return $listeCours;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT c.id_c AS id, c.id_m AS matiere, b.username AS auteur, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
		 	INNER JOIN byte b ON c.id_u = b.id_u
			INNER JOIN matiere m ON c.id_m = m.id_m
			WHERE c.id_c = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
     
		if ($cours = $requete->fetch())
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
       
			return $cours;
		}
     
		return null;
	}
	
	public function setCount($id) {
		$requete = $this->dao->prepare('UPDATE cours
			SET count_c = count_c + 1
			WHERE id_c = :id');
			
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
	}
	
	public function getCount($id) {
		$requete = $this->dao->prepare('SELECT count_c
			FROM cours
			WHERE id_c = :id');
			
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$result = $requete->fetch();
		return $result;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM cours')->fetchColumn();
	}
	
	protected function add(Cours $cours)
	{
		$requete = $this->dao->prepare('INSERT INTO cours SET id_u = :auteur, id_m = :matiere, titre = :titre, description = :description, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
		
	    $requete->bindValue(':auteur', $cours->auteur());
		$requete->bindValue(':matiere', $cours->matiere());
	    $requete->bindValue(':titre', $cours->titre());
		$requete->bindValue(':description', $cours->description());
	    $requete->bindValue(':contenu', $cours->contenu());
 
	    $requete->execute();
	}
	
	protected function modify(Cours $cours)
	{
	    $requete = $this->dao->prepare('UPDATE cours SET id_m = :matiere, titre = :titre, description = :description, contenu = :contenu, dateModif = NOW() WHERE id_c = :id');
	    $requete->bindValue(':matiere', $cours['matiere']);
		$requete->bindValue(':titre', $cours['titre']);
		$requete->bindValue(':description', $cours['description']);
		$requete->bindValue(':contenu', $cours['contenu']);
		$requete->bindValue(':id', $cours['id']);
	    $requete->execute();
	}
	
  	public function delete(Cours $cours)
  	{
  		$this->dao->exec('DELETE FROM cours WHERE id_c = '.$cours['id']);
  	}
	  
	  
}