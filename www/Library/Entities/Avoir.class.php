<?php
namespace Library\Entities;

class Avoir extends \Library\Entity
{
	private $eleve,								// Identifiant de l'élève qui rend son devoir
	$dateRendu,									// Date à laquelle l'élève rend son devoir
	$note;										// Note que le professeur donnera au devoir
	
	public function isValid()
	{
		return !(empty($this->eleve));
	}
	
	public function setEleve($eleve)
	{
		$this->eleve = $eleve;
	}
	
	public function setDateRendu(\DateTime $date)
	{
		$this->dateRendu = $date;
	}
	
	public function setNote($note)
	{
		$this->note = $note;
	}
	
	public function eleve() { return $this->eleve; }
	public function dateRendu() { return $this->dateRendu; }
	public function note() { return $this->note; }
}
?>