<?php
namespace Library\Entities;

class Cours extends \Library\Entity
{
	protected $titre,
	$description,
	$contenu;

	const TITRE_INVALIDE = 1;
	const DESCRIPTION_INVALIDE = 2;
	const CONTENU_INVALIDE = 3;

	public function isValid()
	{
		return !(empty($this->titre) || empty($this->description) || empty($this->contenu));
	}


	// SETTERS

	public function setTitre($title)
	{
		if (!is_string($title) || empty($title))
		{
			$this->erreurs[] = self::TITRE_INVALIDE;
		}
		else
		{
			$this->titre = $title;
		}
	}

	public function setDescription($desc)
	{
		if (!is_string($desc) || empty($desc))
		{
			$this->erreurs[] = self::DESCRIPTION_INVALIDE
		}
		else
		{
			$this->description = $desc;			
		}
	}

	public  function setContenu($contents)
	{
		if (!is_string($contents) || empty($contents))
		{
			$this->erreurs[] = self::CONTENU_INVALIDE
		}
		else
		{
			$this->contenu = $contents;
		}
	}

	//GETTERS

	public function titre(){ return $this->titre;}
	public function description(){ return $this->description;}
	public function contenu(){ return $this->contenu;}
}
?>