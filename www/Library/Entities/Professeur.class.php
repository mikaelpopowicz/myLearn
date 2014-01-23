<?php
namespace Library\Entities;

class Professeur extends \Library\Entities\User
{
	private $anciennete;
	
	public function setAnciennete($ancien)
	{
		$this->anciennete = $ancien;
	}
	
	public function anciennete() { return $this->anciennete; }
}
?>