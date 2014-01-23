<?php
namespace Library\Entities;

class Classe extends \Library\Entity
{
	private $libelle,							// Nom de la classe
	$session,									// Session pendant laquelle la classe existe (clé étrangère)
	$section;									// Section dans laqulle se trouve la classe (clé étrangère)
	
	const LIBELLE_INVALIDE = 1;
   
	public function isValid()
	{
		return !(empty($this->libelle));
	}
	
	public function setLibelle($libelle)
	{
		if (!is_string($libelle) || empty($libelle))
		{
			$this->erreurs[] = self::CONTENU_INVALIDE;
		}
		else
		{
			$this->libelle = $libelle;
		}
	}
	
	public function setSession($session)
	{
		$this->session = $session;
	}
	
	public function setSection($section)
	{
		$this->section = $section;
	}
	
	public function libelle() { return $this->libelle; }
	public function session() { return $this->session; }
	public function section() { return $this->section; }
}
?>