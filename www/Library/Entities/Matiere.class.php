<?php
namespace Library\Entities;

class Matiere extends \Library\Entity {

	protected $libelle,							// Nom de la matière
	$uri,										// URI de la matière
	$icon,										// Icone choisie pour la matière
	$cours;

	const LIBELLE_INVALIDE = 1;
	const ICON_INVALIDE = 2;

	public function isValid()
	{
		return !(empty($this->libelle));
	}
	
	// SETTERS //
   
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
	
	public function setIcon($icon)
	{
		if (!is_string($icon) || empty($icon))
		{
			$this->erreurs[] = self::ICON_INVALIDE;
		}
		else
		{
			$this->icon = $icon;
		}
	}
	
	public function setCours($cours)
	{
		$this->cours = $cours;
	}
	
	// GETTERS //
   
	public function libelle() { return $this->libelle; }
	public function uri() { return $this->uri; }
	public function icon() { return $this->icon; }
	public function cours() { return $this->cours; }
}