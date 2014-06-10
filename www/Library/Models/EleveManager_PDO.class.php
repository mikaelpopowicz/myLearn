<?php
namespace Library\Models;
 
use \Library\Entities\Eleve;
 
class EleveManager_PDO extends EleveManager
{
	public static function getObj($requete, $mode = 'Alone')
	{
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		
		if($mode == 'Alone')
		{
			$result = $requete->fetch();
			$result->setDateUser(new \DateTime($result->dateUser()));
			if($result->dateNaissance() != '0000-00-00')
			{
				$result->setDateNaissance(new \DateTime($result->dateNaissance()));
			}
		}
		else if ($mode == 'Groups')
		{
			$result = $requete->fetchAll();
			foreach ($result as $eleve)
			{
				$eleve->setDateUser(new \DateTime($eleve->dateUser()));
				if($eleve->dateNaissance() != '0000-00-00')
				{
					$eleve->setDateNaissance(new \DateTime($eleve->dateNaissance()));
				}
			}
		}
		
		return $result;
	}
	
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT u.id_u AS id, u.nom, u.prenom, e.dateNaissance, u.dateUser, u.active
										FROM eleve e
										INNER JOIN user u ON u.id_u = e.id_u
										ORDER BY u.nom,u.prenom');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		$listeEleve = $requete->fetchAll();
		foreach ($listeEleve as $eleve) {
			if($eleve->dateNaissance() != '0000-00-00') {
				$eleve->setDateNaissance(new \DateTime($eleve->dateNaissance()));
			}
			$eleve->setDateUser(new \DateTime($eleve->dateUser()));
		}
		$requete->closeCursor();
		return $listeEleve;
	}
	
	public function getListNone($classe)
	{
		$requete = $this->dao->prepare('SELECT u.id_u AS id, u.nom, u.prenom
										FROM eleve e
										INNER JOIN user u ON u.id_u = e.id_u
										WHERE u.id_u NOT IN (
											SELECT id_u
											FROM etre
											WHERE id_classe = :classe)
										');
		$requete->bindValue(':classe', $classe);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		$listeEleve = $requete->fetchAll();
		$requete->closeCursor();
		return $listeEleve;
	}
	
	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT u.id_u AS id, u.nom, u.prenom
										FROM eleve e
										INNER JOIN user u ON u.id_u = e.id_u
										INNER JOIN etre et ON et.id_u = e.id_u
										WHERE et.id_classe = :classe');
		$requete->bindValue(':classe', $classe);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		$listeEleve = $requete->fetchAll();
		$requete->closeCursor();
		return $listeEleve;
	}
	
	public function getLast(Eleve $eleve)
	{
		$requete = $this->dao->prepare('SELECT p.id_u AS id, u.token
										FROM eleve p
										INNER JOIN user u ON p.id_u = u.id_u
										WHERE u.username = :username
										AND u.nom = :nom
										AND u.email = :email');
		$requete->bindValue(':username', $eleve->username());
		$requete->bindValue(':nom', $eleve->nom());
		$requete->bindValue(':email', $eleve->email());
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		if ($eleve = $requete->fetch()) {
			return $eleve;
		}
		return null;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT u.id_u AS id, u.username, u.nom, u.prenom, u.email, u.password, u.salt, u.active, u.token, u.dateUser, e.dateNaissance
										FROM eleve e
										INNER JOIN user u ON u.id_u = e.id_u
										WHERE u.id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		if ($eleve = $requete->fetch()) {
			if($eleve->dateNaissance() != '0000-00-00') {
				$eleve->setDateNaissance(new \DateTime($eleve->dateNaissance()));
			}
			$eleve->setDateUser(new \DateTime($eleve->dateUser()));
			return $eleve;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM eleve')->fetchColumn();
	}
	
	protected function add(Eleve $eleve)
	{
	    $requete = $this->dao->prepare('CALL ajouter_eleve(:nom, :prenom, :email, :dateNaissance)');
	    $requete->bindValue(':nom', $eleve->nom());
	    $requete->bindValue(':prenom', $eleve->prenom());
	    $requete->bindValue(':email', $eleve->email());
	    $requete->bindValue(':dateNaissance', $eleve->dateNaissance()->format('Y-m-d'));
	    $requete->execute();
		$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
		$requete->nextRowSet();
		if($erreur == 0)
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
			$result = $requete->fetch();
		}
		else
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result = $requete->fetch();
		}
		return $result;
	}
	
	protected function modify(Eleve $eleve)
	  {
	    $requete = $this->dao->prepare('CALL up_eleve(:id, :user, :nom, :prenom, :email, :password, :dateNaissance)');
		$requete->bindValue(':id', $eleve->id());
		$requete->bindValue(':user', $eleve->username());
	    $requete->bindValue(':nom', $eleve->nom());
	    $requete->bindValue(':prenom', $eleve->prenom());
	    $requete->bindValue(':email', $eleve->email());
	    $requete->bindValue(':password', $eleve->password());
		if($eleve->dateNaissance() instanceof \DateTime)
		{
			$requete->bindValue(':dateNaissance', $eleve->dateNaissance()->format('Y-m-d'));
		}
		else
		{
			$requete->bindValue(':dateNaissance', $eleve->dateNaissance());
		}
	    
	    $requete->execute();
		$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
		$requete->nextRowSet();
		if($erreur == 1 || $erreur == 0)
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result = $requete->fetch();
			return $result;
		}
		return false;
	  }

  	public function delete(Eleve $eleve)
  	{
  		$this->dao->exec('DELETE FROM eleve WHERE id_u = '.$eleve['id']);
  	}
}