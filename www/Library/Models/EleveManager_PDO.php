<?php
namespace Library\Models;
 
use \Library\Entities\Eleve;
 
class EleveManager_PDO extends EleveManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT id_u AS id FROM eleve');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Eleve');
		$listeByte = $requete->fetchAll();
		$requete->closeCursor();
		return $listeByte;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id FROM user WHERE id_u = :id');
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
	    $requete = $this->dao->prepare('INSERT INTO user SET username = :username, nom = :nom, prenom = :prenom, email = :email, password = :password, salt =:salt, token = :token, dateUser = now()');
	    $requete->bindValue(':username', $user['username']);
		$requete->bindValue(':nom', $user['nom']);
		$requete->bindValue(':prenom', $user['prenom']);
		$requete->bindValue(':email', $user['email']);
		$requete->bindValue(':password', $user['password']);
		$requete->bindValue(':salt', $user['salt']);
		$requete->bindValue(':token', $user['token']);
	    $requete->execute();
	}
	
	protected function modify(Eleve $eleve)
	  {
	    $requete = $this->dao->prepare('UPDATE user SET username = :username, nom = :nom, prenom = :prenom, email = :email, password = :password, salt =:salt, token = :token, active = :active, dateUser = :dateUser WHERE id_u = :id');
	    $requete->bindValue(':username', $user['username']);
		$requete->bindValue(':nom', $user['nom']);
		$requete->bindValue(':prenom', $user['prenom']);
		$requete->bindValue(':email', $user['email']);
		$requete->bindValue(':password', $user['password']);
		$requete->bindValue(':salt', $user['salt']);
		$requete->bindValue(':token', $user['token']);
		$requete->bindValue(':active', $user['active']);
		$requete->bindValue(':dateUser', $user['dateUser']->format('Y-m-d H:i:s'));
		$requete->bindValue(':id', $user['id']);
	    $requete->execute();
	  }

  	public function delete(Eleve $eleve)
  	{
  		$this->dao->exec('DELETE FROM user WHERE id_u = '.$user['id']);
  	}
}