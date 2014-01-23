<?php
namespace Library\Entities;

class Administrateur extends \Library\entities\User
{
	private $poste;
	
	public function setPoste($poste)
	{
		$this->poste = $poste;
	}
	
	public function poste() { return $this->poste; }
}
?>