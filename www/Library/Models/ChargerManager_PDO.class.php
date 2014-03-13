<?php
namespace Library\Models;

use \Library\Entities\Charger;

class ChargerManager_PDO extends \Library\Models\ChargerManager
{
	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT id_classe AS id, id_u AS professeur
			FROM charger
			WHERE id_classe = :id');
		$requete->bindValue(':id', $classe, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Charger');
		$liteCharger = $requete->fetchAll();
		$requete->closeCursor();
		return $liteCharger;
	}
	
	public function countOf($classe)
	{
		return $this->dao->query('SELECT COUNT(*) FROM charger WHERE id_classe = '.$classe)->fetchColumn();
	}
	
	public function add(Charger $charger)
	{
		$requete = $this->dao->prepare('INSERT INTO charger SET id_classe = :id, id_u = :professeur');
		$requete->bindValue(':id', $charger->id());
		$requete->bindValue(':professeur', $charger->professeur());
		$requete->execute();
	}
	
	public function delete(Charger $charger)
	{
		$this->dao->exec('DELETE FROM charger WHERE id_classe = '.$charger->id().' AND id_u = '.$charger->professeur());
	}
}
?>