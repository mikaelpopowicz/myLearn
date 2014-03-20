<?php
namespace Library\Entities;

class Assigner extends \Library\Entity
{
	private $matiere;
	
	public function setMatiere($matiere)
	{
		$this->matiere = $matiere;
	}
	
	public function matiere() { return $this->matiere; }
}
?>