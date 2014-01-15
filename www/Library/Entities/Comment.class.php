<?php
namespace Library\Entities;
 
class Comment extends \Library\Entity
{
	protected $cours,
	$auteur,
	$dateCommentaire,
	$commentaire;
   
	const AUTEUR_INVALIDE = 1;
	const CONTENU_INVALIDE = 2;
   
	public function isValid()
	{
		return !(empty($this->auteur) || empty($this->commentaire) || !empty($this->erreurs));
	}
   
	// SETTERS
   
	public function setCours($cours)
	{
		if(empty($cours))
		{
			$this->erreurs[] = self::COURS_INVALIDE;
		}
		else
		{
			$this->cours = $cours;
		}
	}
   
	public function setAuteur($auteur)
	{
		if (!is_string($auteur) || empty($auteur))
		{
			$this->erreurs[] = self::AUTEUR_INVALIDE;
		}
		else
		{
			$this->auteur = $auteur;
		}
	}
   
	public function setCommentaire($contenu)
	{
		if (!is_string($contenu) || empty($contenu))
		{
			$this->erreurs[] = self::CONTENU_INVALIDE;
		}
		else
		{
			$this->commentaire = $contenu;
		}
	}
   
	public function setDateCommentaire(\DateTime $date)
	{
		$this->dateCommentaire = $date;
	}
   
	// GETTERS

	public function cours() { return $this->cours; }
	public function auteur() { return $this->auteur; }
	public function commentaire() { return $this->commentaire; }
	public function dateCommentaire() { return $this->dateCommentaire; }
}