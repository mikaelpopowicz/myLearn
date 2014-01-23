<?php
namespace Library\Entities;

class Eleve extends \Library\Entity
{
	private $dateNaissance;						// Date de naissance de l'élève
	
	public function setDateNaissance(\DateTime $date)
	{
		$this->dateNaissance = $date;
	}
	
	public function dateNaissance() { return $this->dateNaissance; }
}
?>