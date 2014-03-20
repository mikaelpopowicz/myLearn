<?php
namespace Library\Models;
 
use \Library\Entities\Gestionnaire;
 
class GestionnaireManager_PDO extends GestionnaireManager
{
	public function getList()
	{include 'ProfesseurManager.class.php';
	
		$requete = $this->dao->prepare('SELECT id_u AS id FROM gestionnaire');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Gestionnaire');
		$listeByte = $requete->fetchAll();
		$requete->closeCursor();
		return $listeByte;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id FROM gestionnaire WHERE id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Gestionnaire');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM gestionnaire')->fetchColumn();
	}
	
	protected function add(Gestionnaire $gestionnaire)
	{
	    $requete = $this->dao->prepare('PROCEDURE SQL');
	    $requete->bindValue(':id', $gestionnaire['id']);
	    $requete->execute();
	}
	
	protected function modify(Gestionnaire $gestionnaire)
	  {
	    $requete = $this->dao->prepare('PROCEDURE SQL');
		$requete->bindValue(':id', $professeur['id']);
	    $requete->execute();
	  }

  	public function delete(Gestionnaire $gestionnaire)
  	{
  		$this->dao->exec('DELETE FROM gestionnaire WHERE id_u = '.$gestionnaire['id']);
  	}
}