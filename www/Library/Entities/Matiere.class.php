<?php
namespace Library\Entities;

class Matiere extends \Library\Entity {
	
	protected $libelle,
	$icon;

	const LIBELLE_INVALIDE = 1;
	const ICON_INVALIDE = 2;
	
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
	
	// GETTERS //
   
	public function libelle()
	{
		return $this->libelle;
	}
	
	public function icon()
	{
		return $this->icon;
	}
}