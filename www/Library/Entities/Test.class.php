<?php
namespace Library\Entities;

class Test extends \Library\Entity {
	
	
	private $titre;
	CONST TITRE_INVALIDE = 1;
	
	
	public function isValid()
	{
		return !(empty($this->titre) || !empty($this->erreurs));
	}
	
	// SETTERS //

   
	public function setTitre($titre)
	{
		if (!is_string($titre) || empty($titre))
		{
			$this->erreurs[] = self::TITRE_INVALIDE;
		}
		else
		{
			$this->titre = $titre;
		}
	}
	
	// GETTERS //
   
	public function titre() { return $this->titre; }
}

?>