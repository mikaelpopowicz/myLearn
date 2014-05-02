<?php
namespace Library\Entities;
 
class Vue extends \Library\Entity
{
	protected $cours,
	$visiteur,
	$dateVue;

	const CONTENU_INVALIDE = 1;
   
	public function isValid()
	{
		return !(empty($this->commentaire));
	}
   
	// SETTERS
   
	public function setCours(\Library\Entities\Cours $cours)
	{
		$this->cours = $cours;
	}
   
	public function setVisiteur(\Library\Entities\user $visiteur)
	{
		$this->visiteur = $visiteur;
	}
   
	public function setDateVue(\DateTime $date)
	{
		$this->dateVue = $date;
	}
   
	// GETTERS

	public function cours() { return $this->cours; }
	public function visiteur() { return $this->visiteur; }
	public function dateVue() { return $this->dateVue; }
}