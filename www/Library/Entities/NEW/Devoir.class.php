<?php
namespace Library\Entities;

class Devoir extends \Library\Entity
{
	protected $dateDevoir,
	$enoncer,
	$dateMax,
	$prof,
	$classe;

	const ENONCER_INVALIDE = 1;

	public function isValid()
	{
		return !(empty($this->enoncer));
	}


	// SETTERS

	public function setdateDevoir(\DateTime $dateD)
	{
		$this->dateDevoir = $dateD;
	}

	public function setEnoncer($enoncer)
	{
		if (!is_string($enoncer) || empty($enoncer))
		{
			$this->erreurs[] = self::ENONCER_INVALIDE;
		}
		else
		{
			$this->enoncer = $enoncer;			
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
	public function enoncer(){ return $this->enoncer};
	public function dateMax(){ return $this->dateMax};
	public function prof(){ return $this->prof};
	public function classe(){ return $this->classe};
}
?>