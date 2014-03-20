<?php
namespace Library\Models;

use \Library\Entities\Etre;

class EtreManager_PDO extends \Library\Models\EtreManager
{
	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT id_classe AS id, id_u AS eleve
			FROM etre
			WHERE id_classe = :id');
		$requete->bindValue(':id', $classe, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Etre');
		$liteEtre = $requete->fetchAll();
		$requete->closeCursor();
		return $liteEtre;
	}
	
	public function countOf($classe)
	{
		return $this->dao->query('SELECT COUNT(*) FROM etre WHERE id_classe = '.$classe)->fetchColumn();
	}
	
	public function add(Etre $etre)
	{
		$requete = $this->dao->prepare('INSERT INTO etre SET id_classe = :id, id_u = :eleve');
		$requete->bindValue(':id', $etre->id());
		$requete->bindValue(':eleve', $etre->eleve());
		$requete->execute();
	}
	
	public function delete(Etre $etre)
	{
		$this->dao->exec('DELETE FROM etre WHERE id_classe = '.$etre->id().' AND id_u = '.$etre->eleve());
	}
}
?>