<?php
namespace Library\Models;
 
use \Library\Entities\Byte;
 
class ByteManager_PDO extends ByteManager
{
	public function getList()
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, active, dateByte
			FROM byte');
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Byte');
		$listeByte = $requete->fetchAll();
		foreach ($listeByte as $byte) {
			$byte->setDateByte(new \DateTime($byte['dateByte']));
		}
		$requete->closeCursor();
		return $listeByte;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, password, salt, token, active, dateByte
			FROM byte
			WHERE id_u = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Byte');
		if ($user = $requete->fetch()) {
			$user->setDateByte(new \DateTime($user['dateByte']));
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
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Byte');
		if ($user = $requete->fetch()) {
			return $user;
		}
		return null;
	}
	
	public function getByNamePass($name, $pass)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, password, salt, token, active, dateByte
			FROM user
			WHERE username = :username
			AND password = :password');
		$requete->bindValue(':username', $name);
		$requete->bindValue(':password', $pass);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Byte');
		if ($user = $requete->fetch()) {
			$user->setDateByte(new \DateTime($user['dateByte']));
			return $user;
		}
		return null;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM byte')->fetchColumn();
	}
	
	protected function add(Byte $user)
	{
	    $requete = $this->dao->prepare('INSERT INTO byte SET username = :username, nom = :nom, prenom = :prenom, email = :email, password = :password, salt =:salt, token = :token, dateByte = now()');
	    $requete->bindValue(':username', $user['username']);
		$requete->bindValue(':nom', $user['nom']);
		$requete->bindValue(':prenom', $user['prenom']);
		$requete->bindValue(':email', $user['email']);
		$requete->bindValue(':password', $user['password']);
		$requete->bindValue(':salt', $user['salt']);
		$requete->bindValue(':token', $user['token']);
	    $requete->execute();
	}
	
	protected function modify(Byte $user)
	  {
	    $requete = $this->dao->prepare('UPDATE byte SET username = :username, nom = :nom, prenom = :prenom, email = :email, password = :password, salt =:salt, token = :token, active = :active, dateByte = :dateByte WHERE id_u = :id');
	    $requete->bindValue(':username', $user['username']);
		$requete->bindValue(':nom', $user['nom']);
		$requete->bindValue(':prenom', $user['prenom']);
		$requete->bindValue(':email', $user['email']);
		$requete->bindValue(':password', $user['password']);
		$requete->bindValue(':salt', $user['salt']);
		$requete->bindValue(':token', $user['token']);
		$requete->bindValue(':active', $user['active']);
		$requete->bindValue(':dateByte', $user['dateByte']->format('Y-m-d H:i:s'));
		$requete->bindValue(':id', $user['id']);
	    $requete->execute();
	  }

  	public function delete(Byte $user)
  	{
  		$this->dao->exec('DELETE FROM byte WHERE id_u = '.$user['id']);
  	}
	
	public function getByToken($token)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, password, salt, token, active, dateByte
			FROM byte
			WHERE token = :token');
		$requete->bindValue(':token', $token);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Byte');
		if ($user = $requete->fetch()) {
			$user->setDateByte(new \DateTime($user['dateByte']));
			return $user;
		}
		return null;
	}
	
	public function getByMail($email)
	{
		$requete = $this->dao->prepare('SELECT id_u AS id, username, nom, prenom, email, token, active, dateByte
			FROM byte
			WHERE email = :email');
		$requete->bindValue(':email', $email);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Byte');
		if ($user = $requete->fetch()) {
			$user->setDateByte(new \DateTime($user['dateByte']));
			return $user;
		}
		return null;
	}
	
	public function getTokens() {
		$requete = $this->dao->prepare('SELECT token FROM byte');
		$requete->execute();
		if ($tokens = $requete->fetchAll()) {
			return $tokens;
		}
		return null;
	}
}