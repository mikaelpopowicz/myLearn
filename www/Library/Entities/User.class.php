<?php
namespace Library\Entities;
 
class User extends \Library\Entity
{
	protected $username,
	$nom,
	$prenom,
	$email,
	$password,
	$salt,
	$token,
	$active,
	$dateUser;
	
	const USER_INVALIDE = 1;
	const NOM_INVALIDE = 2;
	const EMAIL_INVALIDE = 3;
	const PASS_INVALIDE = 4;
	const SALT_INVALIDE = 5;
	
	public function isValid()
	{
		return !(empty($this->username) || empty($this->password) || empty($this->email) || empty($this->nom) || !empty($this->erreurs));
	}
	
	
	// SETTERS
	
	public function setUsername($user) 
	{
		if (!is_string($user) || empty($user))
		{
			$this->erreurs[] = self::USER_INVALIDE;
			$this->username = "";
		}
		else
		{
			$this->username = $user;
		}
	}
	
	public function setNom($nom)
	{
		if (!is_string($nom) || empty($nom))
		{
			$this->erreurs[] = self::NOM_INVALIDE;
			$this->nom = "";
		}
		else
		{
			$this->nom = $nom;
		}
	}
	
	public function setPrenom($prenom)
	{
		$this->prenom = $prenom;
	}
	
	public function setEmail($email)
	{
		if (is_string($email) && !empty($email))
		{
			$preg_tel = "#^[a-zA-Z1-9\.\-\_]+@{1}[a-zA-Z1-9\.\-\_]+\.{1}[a-z]{2,4}$#";
			if (preg_match($preg_tel, $email))
			{
				$this->email = $email;
			}
			else
			{
				$this->erreurs[] = self::EMAIL_INVALIDE;
				$this->email = "";
			}
		}
		else
		{
			$this->erreurs[] = self::EMAIL_INVALIDE;
			$this->email = "";
		}
	}
	
	public function setPassword($pass)
	{
		if (!is_string($pass) || empty($pass))
		{
			$this->erreurs[] = self::PASS_INVALIDE;
		}
		else
		{
			$this->password = $pass;
		}
	}
	
	public function setSalt($salt)
	{
		if (!is_string($salt) || empty($salt))
		{
			$this->erreurs[] = self::SALT_INVALIDE;
		}
		else
		{
			$this->salt = $salt;
		}
	}
	
	public function setToken($token)
	{
		$this->token = $token;
	}
	
	public function setActive($active)
	{
		$this->active = $active;
	}
	
	public function setDateUser(\DateTime $date)
	{
		$this->dateUser = $date;
	}
	
	
	// GETTERS
	
	public function username() { return $this->username; }
	public function nom() { return $this->nom; }
	public function prenom() { return $this->prenom; }
	public function email() { return $this->email; }
	public function password() { return $this->password; }
	public function salt() { return $this->salt; }
	public function token() { return $this->token; }
	public function active() { return $this->active; }
	public function dateUser() { return $this->dateUser; }
}
?>