<?php
namespace Library\Entities;	

class LogCon extends \Library\Entity
{
	private $user,
	$login,
	$dateConnexion,
	$etat,
	$source,
	$classe;
	
	public function setUser($user)
	{
		$this->user = $user;
	}
	
	public function setLogin($login)
	{
		$this->login = $login;
	}
	
	public function setDateConnexion(\DateTime $dateConnexion)
	{
		$this->dateConnexion = $dateConnexion;
	}
	
	public function setEtat($etat)
	{
		$this->etat = $etat;
	}
	
	public function setSource($source)
	{
		$this->source = $source;
	}
	
	public function setClasse($class)
	{
		$this->classe = $class;
	}
	
	public function user() { return $this->user;}
	public function login() { return $this->login;}
	public function dateConnexion() { return $this->dateConnexion;}
	public function etat() { return $this->etat;}
	public function source() { return $this->source;}
	public function classe() { return $this->classe;}
}
?>