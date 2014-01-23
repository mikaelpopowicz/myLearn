<?php
namespace Library\Entities;

class Eleve extends \Library\Entities\User
{
	private $dateNaissance;
	
	public function setDateNaissance(\DateTime $date)
	{
		$this->dateNaissance = $date;
	}
	
	public function dateNaissance() { return $this->dateNaissance; }
}
?>