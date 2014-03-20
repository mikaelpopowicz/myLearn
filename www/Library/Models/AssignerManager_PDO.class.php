<?php
namespace Library\Models;

use \Library\Entities\Assigner;

class AssignerManager_PDO extends \Library\Models\AssignerManager
{
	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT id_classe AS id, id_m AS matiere
			FROM assigner
			WHERE id_classe = :id');
		$requete->bindValue(':id', $classe, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Assigner');
		$liteAssigner = $requete->fetchAll();
		$requete->closeCursor();
		return $liteAssigner;
	}
	
	public function countOf($classe)
	{
		return $this->dao->query('SELECT COUNT(*) FROM assigner WHERE id_classe = '.$classe)->fetchColumn();
	}
	
	public function add(Assigner $assigner)
	{
		$requete = $this->dao->prepare('INSERT INTO assigner SET id_classe = :id, id_m = :matiere');
		$requete->bindValue(':id', $assigner->id());
		$requete->bindValue(':matiere', $assigner->matiere());
		$requete->execute();
	}
	
	public function delete(Assigner $assigner)
	{
		$this->dao->exec('DELETE FROM assigner WHERE id_classe = '.$assigner->id().' AND id_m = '.$assigner->matiere());
	}
}
?>