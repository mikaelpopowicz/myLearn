<?php
namespace Library\Entities;

class Matiere extends \Library\Entity
{
	protected $libelle;


	const LIBELLE_INVALIDE = 1;


	public function isValid()
	{
		return !(empty($this->libelle));
	}


	// SETTERS

	public function setLibelle($libelle)
	{
		if (!is_string($lib) || empty($lib))
		{
			$this->erreurs[] = self::LIBELLE_INVALIDE;
		}
		else
		{
			$this->libelle = $libelle;
		}
	}


	//GETTERS

	public function libelle(){ return $this->libelle;}

}
?>