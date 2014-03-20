<?php
namespace Library\Entities;

class Section extends \Library\Entity {
	
	protected  $libelle,						// Nom de la section
	$admin;										// Identifiant de l'administrateur de la section (clé étrangère)
	
	const LIBELLE_INVALIDE = 1;
	
	
	public function isValid()
	{
		return !(empty($this->libelle));
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
		
	public function setAdmin($admin)
	{
		$this->admin = $admin;
	}

	// GETTERS //
   
	public function libelle() { return $this->libelle; }
	public function admin() { return $this->admin; }
}

?>