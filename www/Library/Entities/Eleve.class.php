<?php
namespace Library\Entities;

class Eleve extends \Library\Entitie\User
{
	private $classe,					// Identifiant de la classe dans laquelle se trouve l'élève
	$dateNaissance;						// Date de naissance de l'élève
	
	public function setClasse($classe)
	{
		$this->classe = $classe;
	}
	
	public function setDateNaissance(\DateTime $date)
	{
		$this->dateNaissance = $date;
	}
	
	public function dateNaissance() { return $this->dateNaissance; }
}
?>