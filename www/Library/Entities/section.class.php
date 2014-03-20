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
   
<<<<<<< HEAD
	public function setId_u($id_u)
<<<<<<< HEAD
		{
			$this->id_u = $id_u;
		}
=======
	{
		$this->id_u = $id_u;
>>>>>>> 997bb83b3e65114c5914d1b16bb34cde04da24e9
=======
	public function setAdmin($admin)
	{
		$this->admin = $admin;
>>>>>>> mikael
	}

	// GETTERS //
   
	public function libelle() { return $this->libelle; }
	public function admin() { return $this->admin; }
}

?>