<?php
namespace Library\Models;
 
use \Library\Entities\Administrateur;
 
class AdministrateurManager_PDO extends AdministrateurManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, poste FROM administrateur');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Administrateur');
		$listeByte = $requete->fetchAll();
		$requete->closeCursor();
		return $listeByte;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, poste FROM administrateur WHERE id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Administrateur');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM eleve')->fetchColumn();
	}
	
	protected function add(Administrateur $administrateur)
	{
	    $requete = $this->dao->prepare('PROCEDURE SQL');
	    $requete->bindValue(':id', $administrateur['id']);
	    $requete->execute();
	}
	
	protected function modify(Administrateur $administrateur)
	  {
	    $requete = $this->dao->prepare('PROCEDURE SQL');
		$requete->bindValue(':id', $administrateur['id']);
	    $requete->execute();
	  }

  	public function delete(Administrateur $administrateur)
  	{
  		$this->dao->exec('DELETE FROM administrateur WHERE id_u = '.$administrateur['id']);
  	}
}