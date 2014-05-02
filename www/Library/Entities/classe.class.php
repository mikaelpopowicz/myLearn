<?php
namespace Library\Entities;

class Classe extends \Library\Entity
{
	private $libelle,
	$uri,
	$session,
	$section,
	$matieres,
	$professeurs,
	$eleves;
	
	const LIBELLE_INVALIDE = 1;
   
	public function isValid()
	{
		return !(empty($this->libelle));
	}
	
	public function setLibelle($libelle)
	{
		if (!is_string($libelle) || empty($libelle))
		{
			$this->erreurs[] = self::LIBELLE_INVALIDE;
		}
		else
		{
			$this->libelle = $libelle;
		}
	}
	
	public function setUri($uri)
	{
		$this->uri = $uri;
	}
	
	public function setSession(\Library\Entities\Session $session)
	{
		$this->session = $session;
	}
	
	public function setSection(\Library\Entities\Section $section)
	{
		$this->section = $section;
	}
	
	public function setMatieres(array $matieres = array())
	{
		$this->matieres = $matieres;
	}
	
	public function setProfesseurs(array $professeurs = array())
	{
		$this->professeurs = $professeurs;
	}
	
	public function setEleves(array $eleves = array())
	{
		$this->eleves = $eleves;
	}
	
	public function libelle() { return $this->libelle; }
	public function uri() { return $this->uri; }
	public function session() { return $this->session; }
	public function section() { return $this->section; }
	public function matieres() { return $this->matieres; }
	public function professeurs() { return $this->professeurs; }
	public function eleves() { return $this->eleves; }
}
?>