<?php
namespace Library\Entities;	

class Etre extends \Library\Entity
{
	private $eleve;
	
	public function setEleve($eleve)
	{
		$this->eleve = $eleve;
	}
	
	public function eleve() { return $this->eleve;}
}
?>