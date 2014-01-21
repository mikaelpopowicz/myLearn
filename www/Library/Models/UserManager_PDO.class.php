<?php
namespace Library\Models;
 
use \Library\Entities\User;
 
class UserManager_PDO extends UserManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, active, dateUser
			FROM user');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\User');
		$listeByte = $requete->fetchAll();
		foreach ($listeByte as $byte) {
			$byte->setDateUser(new \DateTime($byte['dateUser']));
		}
		$requete->closeCursor();
		return $listeByte;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, password, salt, token, active, dateUser
			FROM user
			WHERE id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\User');
		if ($user = $requete->fetch()) {
			$user->setDateUser(new \DateTime($user['dateUser']));
			return $user;
		}
		return null;
	}
	
	public function getByName($name)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, salt
			FROM user
			WHERE username = :username');
		$requete->bindValue(':username', $name);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\User');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}
	
	public function getByNamePass($name, $pass)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, password, salt, token, active, dateUser
			FROM user
			WHERE username = :username
			AND password = :password');
		$requete->bindValue(':username', $name);
		$requete->bindValue(':password', $pass);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\User');
		if ($user = $requete->fetch()) {
			$user->setDateUser(new \DateTime($user['dateUser']));
			return $user;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM byte')->fetchColumn();
	}
	
	protected function add(User $user)
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
	
	protected function modify(User $user)
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

  	public function delete(User $user)
  	{
  		$this->dao->exec('DELETE FROM user WHERE id_u = '.$user['id']);
  	}
	
	public function getByToken($token)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, password, salt, token, active, dateUser
			FROM user
			WHERE token = :token');
		$requete->bindValue(':token', $token);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\User');
		if ($user = $requete->fetch()) {
			$user->setDateUser(new \DateTime($user['dateUser']));
			return $user;
		}
		return null;
	}
	
	public function getByMail($email)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, token, active, dateUser
			FROM user
			WHERE email = :email');
		$requete->bindValue(':email', $email);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\User');
		if ($user = $requete->fetch()) {
			$user->setDateUser(new \DateTime($user['dateUser']));
			return $user;
		}
		return null;
	}
	
	public function getTokens() {
		$requete = $this->dao->prepare('SELECT token FROM user');
		$requete->execute();
		if ($tokens = $requete->fetchAll()) {
			return $tokens;
		}
		return null;
	}
}