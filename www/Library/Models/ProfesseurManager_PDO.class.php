<?php
namespace Library\Models;
 
use \Library\Entities\Professeur;
 
class ProfesseurManager_PDO extends ProfesseurManager
{
	public static function getObj($requete, $mode = 'Alone')
	{
		$result = array();
		
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		
		if($mode == 'Alone')
		{
			$result['professeur'] = $requete->fetch();
			$result['professeur']->setDateUser(new \DateTime($result['professeur']->dateUser()));
			$requete->nextRowset();
			$result['matiere'] = \Library\Models\MatiereManager_PDO::getObj($requete);
			$result['professeur']->setMatiere($result['matiere']);
			unset($result['matiere']);
			$result = $result['professeur'];
		}
		else if ($mode == 'Groups')
		{
			$result['professeurs'] = $requete->fetchAll();
			foreach ($result['professeurs'] as $professeur)
			{
				$professeur->setDateUser(new \DateTime($professeur->dateUser()));
			}
		}
		
		return $result;
	}
	
	public function getList()
	{
		
		
		$requete = $this->dao->prepare('SELECT p.id_u AS id, p.id_m AS matiere, u.nom, u.prenom, u.active, u.dateUser
										FROM professeur p
										INNER JOIN user u ON u.id_u = p.id_u');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		$listeProf = $requete->fetchAll();
		$matiere = new \Library\Models\MatiereManager_PDO($this->dao);
		foreach ($listeProf as $prof) {
			$prof->setDateUser(new \DateTime($prof->dateUser()));
			$prof->setMatiere($matiere->getUnique($prof->matiere()));
		}
		$requete->closeCursor();
		return $listeProf;
	}
	
	public function getListNone($classe)
	{
		$requete = $this->dao->prepare('SELECT u.id_u AS id, u.nom, u.prenom
										FROM professeur p
										INNER JOIN user u ON u.id_u = p.id_u
										WHERE u.id_u NOT IN (
											SELECT id_u
											FROM charger
											WHERE id_classe = :classe)
										');
		$requete->bindValue(':classe', $classe);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		$listeEleve = $requete->fetchAll();
		$requete->closeCursor();
		return $listeEleve;
	}
	
	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT u.id_u AS id, u.nom, u.prenom
										FROM professeur p
										INNER JOIN user u ON u.id_u = p.id_u
										INNER JOIN charger c ON c.id_u = p.id_u
										WHERE c.id_classe = :classe');
		$requete->bindValue(':classe', $classe);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		$listeEleve = $requete->fetchAll();
		$requete->closeCursor();
		return $listeEleve;
	}

	public function getLast(Professeur $professeur)
	{
		$requete = $this->dao->prepare('SELECT p.id_u AS id, u.token
										FROM professeur p
										INNER JOIN user u ON p.id_u = u.id_u
										AND u.username = :username
										AND u.nom = :nom
										AND u.email = :email');
		$requete->bindValue(':username', $professeur->username());
		$requete->bindValue(':nom', $professeur->nom());
		$requete->bindValue(':email', $professeur->email());
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}

	public function countOf($matiere)
	{
		return $this->dao->query('SELECT COUNT(*) FROM professeur WHERE id_m = '.$matiere)->fetchColumn();
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT p.id_u AS id, u.username, p.id_m AS matiere, u.nom, u.prenom, u.email, u.dateUser, u.password, u.salt, u.token, u.active
										FROM professeur p
										INNER JOIN user u ON p.id_u = u.id_u
										WHERE p.id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		if ($prof = $requete->fetch()) {			
			$prof->setDateUser(new \DateTime($prof->dateUser()));
			$matiere = new \Library\Models\MatiereManager_PDO($this->dao);
			$prof->setMatiere($matiere->getUnique($prof->matiere()));
			return $prof;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM professeur')->fetchColumn();
	}
	
	protected function add(Professeur $professeur)
	{
	    $requete = $this->dao->prepare('CALL ajouter_prof(:nom, :prenom, :email, :matiere)');
	    $requete->bindValue(':nom', $professeur->nom());
	    $requete->bindValue(':prenom', $professeur->prenom());
	    $requete->bindValue(':email', $professeur->email());
	    $requete->bindValue(':matiere', $professeur->matiere()->id());
	    $requete->execute();
		$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
		$requete->nextRowset();
		if($erreur == 0)
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
			$result = $requete->fetch();
		}
		else
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result = $requete->fetch();
		}
		return $result;
	}
	
	protected function modify(Professeur $professeur)
	{
		$requete = $this->dao->prepare('CALL up_prof(:id, :username, :nom, :prenom, :email, :password, :matiere)');
		$requete->bindValue(':id', $professeur->id());
		$requete->bindValue(':username', $professeur->username());
		$requete->bindValue(':nom', $professeur->nom());
		$requete->bindValue(':prenom', $professeur->prenom());
		$requete->bindValue(':email', $professeur->email());
		$requete->bindValue(':password', $professeur->password());
		$requete->bindValue(':matiere', $professeur->matiere()->id());
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

  	public function delete(Professeur $professeur)
  	{
  		$this->dao->exec('DELETE FROM professeur WHERE id_u = '.$professeur['id']);
  	}
}