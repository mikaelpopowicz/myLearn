<?php
namespace Library\Entities;

class Charger extends \Library\Entity
{
	private $professeur;

	public function setProfesseur($prof)
	{
		$this->professeur = $prof;
	}

	public function professeur() { return $this->professeur; }
}
?>