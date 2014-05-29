<?php
namespace Library\Entities;

class Professeur extends \Library\Entities\User
{
	private $matiere;
	
	public function setMatiere(\Library\Entities\Matiere $matiere)
	{
		$this->matiere = $matiere;
	}
	
	public function matiere() { return $this->matiere; }
}
?>