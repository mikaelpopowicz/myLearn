<?php
namespace Library\Entities\NEW;

class Cours extends \Library\Entity {
	
	protected  $libelle,$id_u; // $administrateur = clé étrangere
	
	const LIBELLE_INVALIDE = 1;
	
	
	public function isValid()
	{
		return !(empty($this->libelle) || (empty($this->id_u)) );
	}
	
	// SETTERS //
   
	public function setLibelle($libelle)
	{
		if (empty($libelle))
		{
			$this->erreurs[] = self::LIBELLE_INVALIDE;
		}
		else
		{
			$this->libelle = $libelle;
		}
	}
   
	public function setId_u($id_u)
		{
			$this->id_u = $id_u;
		}
	}

		// GETTERS //
   
	public function libelle()
	{
		return $this->libelle;
	}
   
	public function id_u()
	{
		return $this->id_u;
	}

}

?>