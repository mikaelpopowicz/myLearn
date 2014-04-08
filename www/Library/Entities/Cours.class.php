<?php
namespace Library\Entities;

class Cours extends \Library\Entity {
	
	protected $auteur,						// Identifiant de l'utilisateur qui a ecrit le cours (clé étrangère)
	$titre,									// Titre du cours
	$uri,									// URI du cours
	$description,							// Description du cours
	$contenu,								// Contenu du cours
	$dateAjout,								// Date de création du cours
	$dateModif,								// Date de la dernière modification du cours
	$matiere,								// Matière à laquelle le cours fait référence (clé étrangère)
	$classe,								// Classe dans laquelle le cours a été donné (clé étrangère)
	$commentaires;
	
	const AUTEUR_INVALIDE = 1;
	const TITRE_INVALIDE = 2;
	const DESCRIPTION_INVALIDE = 3;
	const CONTENU_INVALIDE = 4;
	
	public function isValid()
	{
		return !(empty($this->titre) || empty($this->description) || empty($this->contenu));
	}
	
	// SETTERS //
   
	public function setAuteur(\Library\Entities\User $auteur)
	{
		$this->auteur = $auteur;
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
	
	public function setUri($uri)
	{
		$this->uri = $uri;
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
	
	public function setMatiere(\Library\Entities\Matiere $matiere) {
		$this->matiere = $matiere;
	}
	
	public function setClasse(\Library\Entities\Classe $classe) {
		$this->classe = $classe;
	}
	
	public function setCommentaires(array $commentaires)
	{
		$this->commentaires = $commentaires;
	}

	public function setCount_c($count) {
		$this->count_c = $count;
	}
	
	// GETTERS //
   
	public function auteur() { return $this->auteur; }
    public function titre() { return $this->titre; }
	public function uri() { return $this->uri; }
	public function description() { return $this->description; }
	public function contenu() { return $this->contenu; }
	public function dateAjout() { return $this->dateAjout; }
	public function dateModif() { return $this->dateModif; }
	public function matiere() { return $this->matiere; }
	public function classe() { return $this->classe; }
	public function commentaires() { return $this->commentaires; }
}

?>