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
	
	public function connexion($login, $pass)
	{
		$requete = $this->dao->prepare('CALL connexion(:login, :pass)');
		$requete->bindValue(':login', $login);
		$requete->bindValue(':pass', $pass);
		$requete->execute();
		$erreur = $requete->fetch();
		$requete->nextRowset();
		if($erreur['erreur'] == 0) {
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\User');
			$user = $requete->fetch();
			$user->setDateUser(new \DateTime($user['dateUser']));
			$requete->nextRowset();
			$statut = $requete->fetch(\PDO::FETCH_ASSOC);
			$result = array(
				"user" =>$user,
				"statut" => $statut['Statut']
			);
			if($statut['Statut'] == "Eleve")
			{
				$requete->nextRowset();
				$nombre = $requete->fetch(\PDO::FETCH_ASSOC)['Classes'];
				$listeClasse = array();
				if($nombre > 0)
				{
					$entity = array(
						"Classe",
						"Session",
						"Section",
						"Matiere",
						"Professeur",
						"Eleve"
					);
			
					for($i = 0; $i < $nombre; $i++)
					{
						foreach ($entity as $key) {
							$mode = "\Library\Entities\\".$key;
							$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
							$requete->nextRowset();
							if($key == "Classe")
							{
								$classe = $requete->fetch();
							}
							else
							{
								if ($key == "Session" || $key == "Section")
								{
									$value = $requete->fetch();
									$methode = 'set'.$key;
									$classe->$methode($value);
								}
								else
								{
									$values = $requete->fetchAll();
									$methode = 'set'.$key.'s';
									$classe->$methode($values);
								}
							}
						}
						$listeClasse[] = $classe;
					}
				}
				for ($i=0; $i < count($listeClasse); $i++) { 
					$listeClasse[$i] = base64_encode(serialize($listeClasse[$i]));
				}
				$result['classes'] = $listeClasse;
			}
			
		} else {
			$result = $requete->fetch();
			$result = array(
				"Message" => $result['Message'],
				"Type" => $result['Type']
			);
		}
		return $result;
	}
	
	public function activation($oldTk,$newTk)
	{
		$requete = $this->dao->prepare('CALL activation(:old, :new)');
		$requete->bindValue(':old', $oldTk);
		$requete->bindValue(':new', $newTk);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
		$result = $requete->fetch();
		return $result;
	}
	
	public function activationRequest($mail)
	{
		$requete = $this->dao->prepare('CALL activation_request(:mail)');
		$requete->bindValue(':mail', $mail);
		$requete->execute();
		$erreur = $requete->fetch();
		$result = array();
		$requete->nextRowset();
		if($erreur['erreur'] == 0)
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Crypt');
			$result['mail'] = $requete->fetch();
			$requete->nextRowset();
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result['message'] = $requete->fetch();
		}
		else
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result['message'] = $requete->fetch();
		}
		return $result;
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