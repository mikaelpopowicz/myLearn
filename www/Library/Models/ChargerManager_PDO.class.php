<?php
namespace Library\Models;

use \Library\Entities\Charger;

class ChargerManager_PDO extends \Library\Models\ChargerManager
{
	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT id_classe AS id, id_u AS professeur
			FROM chager
			WHERE id_classe = :id');
		$requete->bindValue(':id', $classe, \PDO::PARAM_INT);
		$requete->execute();

		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Charger');

		$listeCharger = $requete->fetchAll();

		$requete->closeCursor();
     
		return $listeCharger;
	}

	public function getUnique($classe, $prof)
	{
		$requete = $this->dao->prepare('SELECT id_classe AS id, id_u AS professeur
			FROM chager
			WHERE id_classe = :id
			AND id_u = :prof');
		$requete->bindValue(':id', $classe, \PDO::PARAM_INT);
		$requete->bindValue(':prof', $prof, \PDO::PARAM_INT);
		$requete->execute();

		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Charger');

		if($charger = $requete->fetch()) 
		{
			return $charger;
		}

		return null;
	}

	protected function add(Charger $charger)
	{
		$requete = $this->dao->prepare('INSERT INTO charger SET id_classe = :classe, id_u = :prof');
		$requete->bindValue(':classe', $charger->id());
		$requete->bindValue(':prof', $charger->professeur());
		$requete->execute();
	}

	public function delete(Charger $charger)
  	{
  		$this->dao->exec('DELETE FROM charger WHERE id_classe = '.$matiere['id'].' AND id_u = '.$charger['professeur']);
  	}
}
?>