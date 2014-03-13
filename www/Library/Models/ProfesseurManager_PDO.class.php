<?php
namespace Library\Models;
 
use \Library\Entities\Professeur;
 
class ProfesseurManager_PDO extends ProfesseurManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT p.id_u AS id, p.id_m AS matiere, u.nom, u.prenom, u.active, u.dateUser
										FROM professeur p
										INNER JOIN user u ON u.id_u = p.id_u');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Professeur');
		$listeProf = $requete->fetchAll();
		foreach ($listeProf as $prof) {
			$prof->setDateUser(new \DateTime($prof->dateUser()));
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
	    $requete = $this->dao->prepare('CALL ajouter_prof(:username, :nom, :prenom, :email, :password, :salt, :token, :matiere)');
	    $requete->bindValue(':username', $professeur->username());
	    $requete->bindValue(':nom', $professeur->nom());
	    $requete->bindValue(':prenom', $professeur->prenom());
	    $requete->bindValue(':email', $professeur->email());
	    $requete->bindValue(':password', $professeur->password());
	    $requete->bindValue(':salt', $professeur->salt());
	    $requete->bindValue(':token', $professeur->token());
	    $requete->bindValue(':matiere', $professeur->matiere());
	    $requete->execute();
	}
	
	protected function modify(Professeur $professeur)
	  {
  	    $requete = $this->dao->prepare('CALL up_prof(:id, :username, :nom, :prenom, :email, :password, :active, :salt, :token, :matiere)');
		$requete->bindValue(':id', $professeur->id());
  	    $requete->bindValue(':username', $professeur->username());
  	    $requete->bindValue(':nom', $professeur->nom());
  	    $requete->bindValue(':prenom', $professeur->prenom());
  	    $requete->bindValue(':email', $professeur->email());
  	    $requete->bindValue(':password', $professeur->password());
		$requete->bindValue(':active', $professeur->active());
  	    $requete->bindValue(':salt', $professeur->salt());
  	    $requete->bindValue(':token', $professeur->token());
  	    $requete->bindValue(':matiere', $professeur->matiere());
  	    $requete->execute();
	  }

  	public function delete(Professeur $professeur)
  	{
  		$this->dao->exec('DELETE FROM professeur WHERE id_u = '.$professeur['id']);
  	}
}