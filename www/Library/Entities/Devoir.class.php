<?php
namespace Library\Entities;

class Devoir extends \Library\Entity
{
	protected $dateDevoir,
	$libelle,
	$enonce,
	$dateMax,
	$professeur,
	$classe,
	$pieces,
	$rendus,
	$active;

	const ENONCE_INVALIDE = 1;
	const LIBELLE_INVALIDE = 2;

	public function isValid()
	{
		return !(empty($this->enonce) || empty($this->libelle));
	}


	// SETTERS

	public function setdateDevoir(\DateTime $dateD)
	{
		$this->dateDevoir = $dateD;
	}

	public function setEnonce($enonce)
	{
		if (!is_string($enonce) || empty($enonce))
		{
			$this->erreurs[] = self::ENONCE_INVALIDE;
		}
		else
		{
			$this->enonce = $enonce;			
		}
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

	public function setDateMax(\DateTime $dateM)
	{
		$this->dateMax = $dateM;
	}

	public function setProfesseur($professeur)
	{
		$this->professeur = $professeur;
	}

	public function setClasse($classe)
	{
		$this->classe = $classe;
	}
	
	public function setPieces($pieces)
	{
		$this->pieces = $pieces;
	}
	
	public function setRendus($rendus)
	{
		$this->rendus = $rendus;
	}
	
	public function setActive($active)
	{
		$this->active = $active;
	}


	//GETTERS

	public function dateDevoir() { return $this->dateDevoir;}
	public function enonce() { return $this->enonce;}
	public function libelle() { return $this->libelle;}
	public function dateMax() { return $this->dateMax;}
	public function professeur() { return $this->professeur;}
	public function classe() { return $this->classe;}
	public function pieces() { return $this->pieces;}	
	public function rendus() { return $this->rendus;}
	public function active() { return $this->active;}
}
?>