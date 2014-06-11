<?php
namespace Library\Entities;

class Rendu extends \Library\Entity
{
	protected $eleve,
	$commentaire,
	$note,
	$pieces;
	
	public function isValid()
	{
		return !(empty($this->eleve));
	}
	
	// SETTERS

	public function setEleve(\Library\Entities\Eleve $eleve)
	{
		$this->eleve = $eleve;
	}

	public function setNote($note)
	{
		$this->note = $note;
	}
	
	public function setCommentaire($commentaire)
	{
		$this->commentaire = $commentaire;
	}
	
	public function setPieces($pieces)
	{
		$this->pieces = $pieces;
	}

	//GETTERS

	public function eleve() { return $this->eleve;}
	public function note() { return $this->note;}
	public function commentaire() { return $this->commentaire;}
	public function pieces() { return $this->pieces;}
}
?>