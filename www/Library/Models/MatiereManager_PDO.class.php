<?php
namespace Library\Models;
 
use \Library\Entities\Matiere;
 
class MatiereManager_PDO extends MatiereManager
{
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_m AS id, libelle, icon
			FROM matiere
			WHERE id_m = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
     
		if ($matiere = $requete->fetch())
		{
			return $matiere;
		}
     
		return null;
	}
	
	public function getList()
	{
		$sql = 'SELECT id_m as id, libelle, icon
			FROM matiere
			ORDER BY libelle';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
     
		$listeMatiere = $requete->fetchAll();
     
		$requete->closeCursor();
     
		return $listeMatiere;
	}
	
	public function getCountCours($id) {
		return $this->dao->query('SELECT COUNT(id_c) FROM cours WHERE id_m = '.$id)->fetchColumn();
	}
	
	public function getByName($libelle) {
		
		$requete = $this->dao->prepare('SELECT id_m AS id, libelle, icon FROM matiere WHERE libelle = :libelle');
		$requete->bindValue(':libelle', $libelle, \PDO::PARAM_STR);
		$requete->execute();
 
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
 
		if ($matiere = $requete->fetch())
		{
			return $matiere;
		}
 
		return null;
	}
	
	protected function add(Matiere $matiere)
	{
		$requete = $this->dao->prepare('INSERT INTO matiere SET libelle = :libelle, icon = :icon');
		$requete->bindValue(':libelle', $matiere->libelle());
		$requete->bindValue(':icon', $matiere->icon());
		$requete->execute();
	}

	protected function modify(Matiere $matiere)
	{
		$requete = $this->dao->prepare('UPDATE matiere SET libelle = :libelle, icon = :icon WHERE id_m = :id');
		$requete->bindValue(':libelle', $matiere->libelle());
		$requete->bindValue(':icon', $matiere->icon());
		$requete->bindValue(':id', $matiere->id());
		$requete->execute();
	}

	public function delete(Matiere $matiere)
  	{
  		$this->dao->exec('DELETE FROM matiere WHERE id_m = '.$matiere['id']);
  	}
}