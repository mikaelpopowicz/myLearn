<?php
namespace Library\Entities;
 
class Comment extends \Library\Entity
{
	protected $cours,							// Identifiant du cours commenté (clé étrangère)
	$auteur,									// Identifiant de l'utilisateur qui a commenté (clé étrangère)
	$dateCommentaire,							// Date à laquelle le commentaire a été fait (entité embarquée)
	$commentaire;								// Contenu du commentaire

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
   
	public function setAuteur(\Library\Entities\user $auteur)
	{
		$this->auteur = $auteur;
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