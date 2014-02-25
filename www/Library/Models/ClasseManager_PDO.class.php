<?php
namespace Library\Models;
 
use \Library\Entities\Classe;
 
class ClasseManager_PDO extends ClasseManager
{
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_classe AS id, id_session AS session, id_section AS section, libelle
			FROM classe
			WHERE id_classe = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Classe');
     
		if ($classe = $requete->fetch())
		{
			return $classe;
		}
     
		return null;
	}
	
	public function getList()
	{
		$sql = 'SELECT id_classe AS id, id_session AS session, id_section AS section, libelle
			FROM classe
			ORDER BY libelle DESC';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Classe');
     
		$listeClasse = $requete->fetchAll();
     
		$requete->closeCursor();
     
		return $listeClasse;
	}

	public function enCours()
	{
		$sql = 'SELECT trouver_session() AS encours';
		$requete = $this->dao->query($sql);
		if($result = $requete->fetch())
		{
			return $result['encours'];
		}
		return null;
	}
	
	protected function add(Classe $classe)
	{
		$requete = $this->dao->prepare('INSERT INTO classe SET id_session = :session, id_section = :section, libelle = :libelle');
		$requete->bindValue(':session', $classe->session());
		$requete->bindValue(':section', $classe->section());
		$requete->bindValue(':libelle', $classe->libelle());
		$requete->execute();
	}

	protected function modify(Classe $classe)
	{
		$requete = $this->dao->prepare('UPDATE classe SET id_session = :session, id_section = :section, libelle = :libelle WHERE id_classe = :id');
		$requete->bindValue(':session', $classe->session());
		$requete->bindValue(':section', $classe->section());
		$requete->bindValue(':libelle', $classe->libelle());
		$requete->bindValue(':id', $classe->id());
		$requete->execute();
	}

	public function delete(Classe $classe)
  	{
  		$this->dao->exec('DELETE FROM classe WHERE id_classe = '.$classe['id']);
  	}
}