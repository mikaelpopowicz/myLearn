<?php
namespace Library\Models;
 
use \Library\Entities\Professeur;
 
class ProfesseurManager_PDO extends ProfesseurManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, id_m AS matiere FROM professeur');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		$listeByte = $requete->fetchAll();
		$requete->closeCursor();
		return $listeByte;
	}

	public function countOf($matiere)
	{
		return $this->dao->query('SELECT COUNT(*) FROM professeur WHERE id_m = '.$matiere)->fetchColumn();
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, id_m AS matiere FROM professeur WHERE id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM professeur')->fetchColumn();
	}
	
	protected function add(Professeur $professeur)
	{
	    $requete = $this->dao->prepare('PROCEDURE SQL');
	    $requete->bindValue(':id', $professeur['id']);
	    $requete->execute();
	}
	
	protected function modify(Professeur $professeur)
	  {
	    $requete = $this->dao->prepare('PROCEDURE SQL');
		$requete->bindValue(':id', $professeur['id']);
	    $requete->execute();
	  }

  	public function delete(Professeur $professeur)
  	{
  		$this->dao->exec('DELETE FROM professeur WHERE id_u = '.$professeur['id']);
  	}
}