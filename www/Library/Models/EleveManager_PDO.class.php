<?php
namespace Library\Models;
 
use \Library\Entities\Eleve;
 
class EleveManager_PDO extends EleveManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, dateNaissance FROM eleve');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		$listeByte = $requete->fetchAll();
		$requete->closeCursor();
		return $listeByte;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, dateNaissance FROM eleve WHERE id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM eleve')->fetchColumn();
	}
	
	protected function add(Eleve $eleve)
	{
	    $requete = $this->dao->prepare('PROCEDURE SQL');
	    $requete->bindValue(':id', $eleve['id']);
	    $requete->execute();
	}
	
	protected function modify(Eleve $eleve)
	  {
	    $requete = $this->dao->prepare('PROCEDURE SQL');
		$requete->bindValue(':id', $eleve['id']);
	    $requete->execute();
	  }

  	public function delete(Eleve $eleve)
  	{
  		$this->dao->exec('DELETE FROM eleve WHERE id_u = '.$eleve['id']);
  	}
}