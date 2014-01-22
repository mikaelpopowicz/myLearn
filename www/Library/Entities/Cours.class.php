<?php
namespace Library\Entities;

class Cours extends \Library\Entity {
	
	protected $auteur,
	$titre,
	$description,
	$contenu,
	$dateAjout,
	$dateModif,
	$matiere,
	$count_c; // NOMBRE DE VUES (le cours)
	
	const AUTEUR_INVALIDE = 1;
	const TITRE_INVALIDE = 2;
	const DESCRIPTION_INVALIDE = 3;
	const CONTENU_INVALIDE = 4;
	
	public function isValid()
	{
		return !(empty($this->titre) || empty($this->description) || empty($this->contenu));
	}
	
	// SETTERS //
   
	public function setAuteur($auteur)
	{
		if (empty($auteur))
		{
			$this->erreurs[] = self::AUTEUR_INVALIDE;
		}
		else
		{
			$this->auteur = $auteur;
		}
	}
   
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
	
	public function setDescription($description)
	{
		if (!is_string($description) || empty($description))
		{
			$this->erreurs[] = self::DESCRIPTION_INVALIDE;
		}
		else
		{
			$this->description = $description;
		}
	}
   
	public function setContenu($contenu)
	{
		if (!is_string($contenu) || empty($contenu))
		{
			$this->erreurs[] = self::CONTENU_INVALIDE;
		}
		else
		{
			$this->contenu = $contenu;
		}
	}
   
	public function setDateAjout(\DateTime $dateAjout)
	{
		$this->dateAjout = $dateAjout;
	}
   
	public function setDateModif(\DateTime $dateModif)
	{
		$this->dateModif = $dateModif;
	}
	
	public function setMatiere($matiere) {
		$this->matiere = (int)$matiere;
	}

	public function setCount_c($count) {
		$this->count_c = $count;
	}
	
	// GETTERS //
   
	public function auteur()
	{
		return $this->auteur;
	}
   
	public function titre()
	{
		return $this->titre;
	}
	
	public function description()
	{
		return $this->description;
	}
   
	public function contenu()
	{
		return $this->contenu;
	}
   
	public function dateAjout()
	{
		return $this->dateAjout;
	}
   
	public function dateModif()
	{
		return $this->dateModif;
	}
	
	public function matiere() {
		return $this->matiere;
	}

	public function count_c() {
		return $this->count_c;
	}
}

?>