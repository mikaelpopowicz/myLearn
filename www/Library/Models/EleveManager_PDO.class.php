<?php
namespace Library\Models;
 
use \Library\Entities\Eleve;
 
class EleveManager_PDO extends EleveManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT u.id_u AS id, u.nom, u.prenom, e.dateNaissance, u.dateUser
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
	
	public function getLast(Eleve $eleve)
	{
		$requete = $this->dao->prepare('SELECT p.id_u AS id, u.token
										FROM eleve p
										INNER JOIN user u ON p.id_u = u.id_u
										AND u.username = :username
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
		$requete = $this->dao->prepare('SELECT id_u AS id, dateNaissance FROM eleve WHERE id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM eleve')->fetchColumn();
	}
	
	protected function add(Eleve $eleve)
	{
	    $requete = $this->dao->prepare('CALL ajouter_eleve(:username, :nom, :prenom, :email, :password, :salt, :token, :dateNaissance)');
	    $requete->bindValue(':username', $eleve->username());
	    $requete->bindValue(':nom', $eleve->nom());
	    $requete->bindValue(':prenom', $eleve->prenom());
	    $requete->bindValue(':email', $eleve->email());
	    $requete->bindValue(':password', $eleve->password());
	    $requete->bindValue(':salt', $eleve->salt());
	    $requete->bindValue(':token', $eleve->token());
	    $requete->bindValue(':dateNaissance', $eleve->dateNaissance()->format('Y-m-d'));
	    $requete->execute();
	}
	
	protected function modify(Eleve $eleve)
	  {
	    $requete = $this->dao->prepare('PROCEDURE SQL');
		$requete->bindValue(':id', $eleve['id']);
	    $requete->execute();
	  }

  	public function delete(Eleve $eleve)
  	{
  		$this->dao->exec('DELETE FROM eleve WHERE id_u = '.$eleve['id']);
  	}
}