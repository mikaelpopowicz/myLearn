<?php
namespace Library\Entities;

class Assigner extends \Library\Entity
{
	private $classe;							// Classe à laquelle est assigné la matière
	
	public function isValid()
	{
		return !(empty($this->classe));
	}
	
	public function setClasse($classe)
	{
		$this->classe = $classe;
	}
	
	public function classe() { return $this->classe; }
}
?>