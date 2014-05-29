<?php
namespace Library\Models;
use \Library\Entities\Devoir;
class DevoirManager_PDO extends DevoirManager
{
	public function getList()
	{
		$sql = 'SELECT d.id_d AS id, d.dateDevoir, d.enonce, d.dateMax, p.id_p AS prof, c.id_classe AS classe
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_p 
			INNER JOIN classe c ON c.id_classe = d.id_classe';
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

	public function getListOfTeacher($professeur)
	{
		$requete = $this->dao->prepare('SELECT d.id_d AS id, d.dateDevoir, d.enonce, d.dateMax, p.id_p AS prof, c.id_classe AS classe
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_p 
			INNER JOIN classe c ON c.id_classe = d.id_classe
			WHERE p.id_p = :id_p');
		$requete->bindValue(':id_p', $professeur, \PDO::PARAM_INT);
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

	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT d.id_d AS id, d.dateDevoir, d.enonce, d.dateMax, p.id_p AS prof, c.id_classe AS classe
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_p
			INNER JOIN classe c ON c.id_classe = d.id_classe
			WHERE c.id_classe = :classe');
		$requete->bindValue(':classe', $classe, \PDO::PARAM_INT);
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

	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT d.id_d AS id, d.dateDevoir, d.enonce, d.dateMax, p.id_p AS prof, c.id_classe AS classe
			FROM devoir d
			INNER JOIN professeur p ON p.id_p = d.id_p
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

	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM devoir')->fetchColumn();
	}

	protected function add(Devoir $devoir)
	{
		$requete = $this->dao->prepare('INSERT INTO devoir SET id_p = :prof, id_c = :classe, enonce = :enoncer, dateDevoir = CURDATE(), dateMax = :dateMax');
		
	    $requete->bindValue(':prof', $devoir->prof());
		$requete->bindValue(':classe', $devoir->classe());
	    $requete->bindValue(':ennoncer', $devoir->ennoncer());
	    $requete->bindValue(':dateMax', $devoir->dateMax()->format('Y-m-d'));
 
	    $requete->execute();
	}
	
	protected function modify(Devoir $devoir)
	{
	    $requete = $this->dao->prepare('UPDATE devoir SET id_p = :prof, id_c = :classe, enonce = :enoncer, dateDevoir = :dateDevoir, dateMax = :dateMax WHERE id_d = :id');
		$requete->bindValue(':prof', $devoir['prof']);
	    $requete->bindValue(':classe', $devoir['classe']);
		$requete->bindValue(':enoncer', $devoir['enoncer']);
		$requete->bindValue(':dateMax', $devoir['dateMax']);
		$requete->bindValue(':id', $devoir['id']);
	    $requete->execute();
	}
	
  	public function delete(Devoir $devoir)
  	{
  		$this->dao->exec('DELETE FROM devoir WHERE id_d = '.$devoir['id']);
  	} 
}