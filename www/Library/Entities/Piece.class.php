<?php
namespace Library\Entities;

class Piece extends \Library\Entity {

	protected $libelle,
	$chemin,
	$dateUpload,
	$devoir;

	const LIBELLE_INVALIDE = 1;

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
	
	public function setChemin($chemin)
	{
		$this->chemin = $chemin;
	}
	
	public function setDateUpload(\DateTime $dateUplaod)
	{
		$this->dateUpload = $dateUplaod;
	}
	
	public function setDevoir($devoir)
	{
		$this->devoir = $devoir;
	}
	
	// GETTERS //
   
	public function libelle() { return $this->libelle;}
	public function chemin() { return $this->chemin;}
	public function dateUpload() { return $this->dateUpload;}
	public function devoir() { return $this->devoir;}
}