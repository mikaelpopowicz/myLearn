<?php
namespace Library\Entities;

class Devoir extends \Library\Entity
{
	protected $dateDevoir,						// Date de création
	$enonce,									// Enoncé du devoir
	$dateMax,									// Date limite pour rendre le devoir
	$prof,										// Identifiant du professeur qui à créé le devoir (clé étrangère)
	$classe;									// Identifiant de la classe pour laquelle le devoir a été fait (clé étrangère)

	const ENONCE_INVALIDE = 1;

	public function isValid()
	{
		return !(empty($this->enonce));
	}


	// SETTERS

	public function setdateDevoir(\DateTime $dateD)
	{
		$this->dateDevoir = $dateD;
	}

	public function setEnoncer($enonce)
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

	public  function setDateMax(\DateTime $dateM)
	{
		$this->dateMax = $dateM;
	}

	public function setProf($prof)
	{
		$this->prof = $prof;
	}

	public function setClasse($classe)
	{
		$this->classe = $classe;
	}


	//GETTERS

	public function dateDevoir(){ return $this->dateDevoir};
	public function enoncer(){ return $this->enonce};
	public function dateMax(){ return $this->dateMax};
	public function prof(){ return $this->prof};
	public function classe(){ return $this->classe};
}
?>