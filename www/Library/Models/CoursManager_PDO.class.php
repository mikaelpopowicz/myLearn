<?php
namespace Library\Models;
 
use \Library\Entities\Cours;
 
class CoursManager_PDO extends CoursManager
{
	public function getList()
	{
		$sql = 'SELECT c.id_c as id, b.username AS auteur, c.id_m AS matiere, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
			INNER JOIN byte b ON c.id_u = b.id_u
			ORDER BY id_c DESC';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
     
		$listeCours = $requete->fetchAll();
     
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
     
		$requete->closeCursor();
     
		return $listeCours;
	}
	
	public function getListByClasseMatiere($classe,$matiere)
	{
		$requete = $this->dao->prepare('CALL select_cours_classe_matiere(:classe,:matiere)');
		$requete->bindValue(':classe', $classe);
		$requete->bindValue(':matiere', $matiere);
		//echo "<pre><br/><br/><br/><br/><br/>Classe : ".$classe." - matiere : ".$matiere."</pre>";
		$requete->execute();
		$nombre = $requete->fetch()['Cours'];
		$cours = array();
		if($nombre > 0)
		{
			//echo '<pre>Nombre de cours => '.$nombre.'</pre>';
			for ($i=0; $i < $nombre; $i++) { 
				$requete->nextRowset();
				$entity = array(
					"Cours",
					"Matiere",
					"User",
					"Classe",
					"Comment"
				);
				foreach ($entity as $key) {
					if($key != "Classe" && $key != "Comment")
					{
						$mode = "\Library\Entities\\".$key;
						$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
						if($key == "Cours")
						{
							$cours[$i] = $requete->fetch();
							$cours[$i]->setDateAjout(new \DateTime($cours[$i]->dateAjout()));
							$cours[$i]->setDateModif(new \DateTime($cours[$i]->dateModif()));
							//echo '<pre>Cours n: '.($i+1)."<br/>";print_r($cours[$i]);echo '</pre>';
						}
						else
						{
							$requete->nextRowset();
							$value = $requete->fetch();
							//echo '<pre>Objet : '.$key.' - mode : '.$mode.'</pre><pre>';print_r($value);echo '</pre>';				
							$methode = "set".$key;
							if($key == "User")
							{
								$methode = "setAuteur";
							}
							//echo '<pre>Méthode appelée :'.$methode.'</pre>';
							$cours[$i]->$methode($value);
							//echo '<pre>Cours n: '.($i+1)."<br/>";print_r($cours[$i]);echo '</pre>';
						}
					}
					else if($key == "Classe")
					{
						$entities = array(
							"Classe",
							"Session",
							"Section",
							"Matiere",
							"Professeur",
							"Eleve"
						);
						foreach ($entities as $cle) {
							$requete->nextRowset();
							$mode = "\Library\Entities\\".$cle;
							$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
							if($cle == "Classe")
							{
								$classe = $requete->fetch();
							}
							else
							{
								if ($cle == "Session" || $cle == "Section")
								{
									$value = $requete->fetch();
									$methode = 'set'.$cle;
									$classe->$methode($value);
								}
								else
								{
									$values = $requete->fetchAll();
									$methode = 'set'.$cle.'s';
									$classe->$methode($values);
								}
							}
						}
						$cours[$i]->setClasse($classe);
					}
					else if($key == "Comment")
					{
						$requete->nextRowset();
						$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Commentaires'];
						$comments = array();
						if($nombre > 0)
						{
							for ($j=0; $j < $nb; $j++) { 
								$requete->nextRowset();
								$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\Comment");
								$comments[$j] = $requete->fetch();
								$comments[$j]->setDateCommentaire(new \DateTime($comments[$j]->dateCommentaire()));
								$requete->nextRowset();
								$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\User");
								$auteur = $requete->fetch();
								$comments[$j]->setAuteur($auteur);
							}
						}
						$cours[$i]->setCommentaires($comments);
					}
				}
			}
		}
		$requete->closeCursor();
		//echo '<pre><br/><br/><br/><br/>';print_r($cours);echo '</pre>';
		return $cours;
		
	}

	public function getListByAuthor($auteur)
	{
		$requete = $this->dao->prepare('CALL select_cours_auteur(:id)');
		$requete->bindValue(':id', $auteur);
		$requete->execute();
		$nombre = $requete->fetch()['Cours'];
		$cours = array();
		if($nombre > 0)
		{
			for ($i=0; $i < $nombre; $i++) {
				$requete->nextRowset();
				$entity = array(
					"Cours",
					"Matiere",
					"User",
					"Classe",
					"Comment"
				);
				foreach ($entity as $key) {
					if($key != "Classe" && $key != "Comment")
					{
						$mode = "\Library\Entities\\".$key;
						$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
						if($key == "Cours")
						{
							$cours[$i] = $requete->fetch();
							$cours[$i]->setDateAjout(new \DateTime($cours[$i]->dateAjout()));
							$cours[$i]->setDateModif(new \DateTime($cours[$i]->dateModif()));
						}
						else
						{
							$requete->nextRowset();
							$value = $requete->fetch();			
							$methode = "set".$key;
							if($key == "User")
							{
								$methode = "setAuteur";
							}
							$cours[$i]->$methode($value);
						}
					}
					else if($key == "Classe")
					{
						$entities = array(
							"Classe",
							"Session",
							"Section",
							"Matiere",
							"Professeur",
							"Eleve"
						);
						foreach ($entities as $cle) {
							$requete->nextRowset();
							$mode = "\Library\Entities\\".$cle;
							$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
							if($cle == "Classe")
							{
								$classe = $requete->fetch();
							}
							else
							{
								if ($cle == "Session" || $cle == "Section")
								{
									$value = $requete->fetch();
									$methode = 'set'.$cle;
									$classe->$methode($value);
								}
								else
								{
									$values = $requete->fetchAll();
									$methode = 'set'.$cle.'s';
									$classe->$methode($values);
								}
							}
						}
						$cours[$i]->setClasse($classe);
					}
					else if($key == "Comment")
					{
						$requete->nextRowset();
						$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Commentaires'];
						$comments = array();
						if($nombre > 0)
						{
							for ($j=0; $j < $nb; $j++) { 
								$requete->nextRowset();
								$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\Comment");
								$comments[$j] = $requete->fetch();
								$comments[$j]->setDateCommentaire(new \DateTime($comments[$j]->dateCommentaire()));
								$requete->nextRowset();
								$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\User");
								$auteur = $requete->fetch();
								$comments[$j]->setAuteur($auteur);
							}
						}
						$cours[$i]->setCommentaires($comments);
					}
				}
			}
		}
		$requete->closeCursor();
		return $cours;
	}
	
	public function getListOf($matiere)
	{
		$requete = $this->dao->prepare('SELECT c.id_c AS id, b.username AS auteur, c.id_m as matiere, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
			INNER JOIN matiere m ON c.id_m = m.id_m
			WHERE m.libelle = :libelle
			ORDER BY dateAjout DESC');
		$requete->bindValue(':libelle', $matiere, \PDO::PARAM_STR);
		$requete->execute();
		
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
     
		$listeCours = $requete->fetchAll();
     
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
     
		$requete->closeCursor();
     
		return $listeCours;
	}

	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM cours')->fetchColumn();
	}

	public function countOf($matiere)
	{
		return $this->dao->query('SELECT COUNT(*) FROM cours WHERE id_m = '.$matiere)->fetchColumn();
	}
	
	public function getLast() {
		$requete = $this->dao->prepare('SELECT c.id_c AS id, c.id_m AS matiere, b.username AS auteur, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
		 	INNER JOIN byte b ON c.id_u = b.id_u
			INNER JOIN matiere m ON c.id_m = m.id_m
			ORDER BY dateModif DESC
			LIMIT 5');
			
		$requete->execute();
	
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
 
		$listeCours = $requete->fetchAll();
 
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
 
		$requete->closeCursor();
 
		return $listeCours;
	}
	
	public function getPopular() {
		$requete = $this->dao->prepare('SELECT c.id_c AS id, c.id_m AS matiere, b.username AS auteur, c.titre, c.description, c.contenu, c.dateAjout, c.dateModif, c.count_c
			FROM cours c
		 	INNER JOIN byte b ON c.id_u = b.id_u
			INNER JOIN matiere m ON c.id_m = m.id_m
			ORDER BY count_c DESC
			LIMIT 5');
			
		$requete->execute();
	
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
 
		$listeCours = $requete->fetchAll();
 
		foreach ($listeCours as $cours)
		{
			$cours->setDateAjout(new \DateTime($cours->dateAjout()));
			$cours->setDateModif(new \DateTime($cours->dateModif()));
		}
 
		$requete->closeCursor();
 
		return $listeCours;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('CALL select_cours(:id)');
		$requete->bindValue(':id', $id);
		$requete->execute();
		$entity = array(
			"Cours",
			"Matiere",
			"User",
			"Classe",
			"Comment"
		);
		foreach ($entity as $key) {
			if($key != "Classe" || $key == "Comment")
			{
				$mode = "\Library\Entities\\".$key;
				$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
				if($key == "Cours")
				{
					$cours = $requete->fetch();
					if(isset($cours['Message']))
					{
						$cours = $cours['Message'];
						return $cours;
					}
					$cours->setDateAjout(new \DateTime($cours->dateAjout()));
					$cours->setDateModif(new \DateTime($cours->dateModif()));
					//echo '<pre>Cours n: '.($i+1)."<br/>";print_r($cours[$i]);echo '</pre>';
				}
				else
				{
					$requete->nextRowset();
					$value = $requete->fetch();
					//echo '<pre>Objet : '.$key.' - mode : '.$mode.'</pre><pre>';print_r($value);echo '</pre>';				
					$methode = "set".$key;
					if($key == "User")
					{
						$methode = "setAuteur";
					}
					//echo '<pre>Méthode appelée :'.$methode.'</pre>';
					$cours->$methode($value);
					//echo '<pre>Cours n: '.($i+1)."<br/>";print_r($cours[$i]);echo '</pre>';
				}
			}
			else if($key == "Classe")
			{
				$entities = array(
					"Classe",
					"Session",
					"Section",
					"Matiere",
					"Professeur",
					"Eleve"
				);
				foreach ($entities as $cle) {
					$requete->nextRowset();
					$mode = "\Library\Entities\\".$cle;
					$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
					if($cle == "Classe")
					{
						$classe = $requete->fetch();
					}
					else
					{
						if ($cle == "Session" || $cle == "Section")
						{
							$value = $requete->fetch();
							$methode = 'set'.$cle;
							$classe->$methode($value);
						}
						else
						{
							$values = $requete->fetchAll();
							$methode = 'set'.$cle.'s';
							$classe->$methode($values);
						}
					}
				}
				$cours->setClasse($classe);
			}
			else if($key == "Comment")
			{
				$requete->nextRowset();
				$nombre = $requete->fetch()['Commentaires'];
				$comments = array();
				echo '<pre><br/><br/><br/><br/><br/>'.$nombre.'</pre>';
				if($nombre > 0)
				{
					for ($i=0; $i < $nombre; $i++) { 
						$requete->nextRowset();
						$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\Comment");
						$comments[$i] = $requete->fetch();
						$comments[$i]->setDateCommentaire(new \DateTime($com->dateCommentaire));
						$requete->nextRowset();
						$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\User");
						$auteur = $requete->fetch();
						$comments[$i]->setAuteur($auteur);
					}
				}
				$cours->setCommentaires($comments);
			}
		}
		return $cours;
	}
	
	public function getByNameClasseMatiere($titre,$classe,$matiere)
	{
		$requete = $this->dao->prepare('CALL select_cours_unique_classe_matiere(:titre,:classe,:matiere)');
		$requete->bindValue(':titre', $titre);
		$requete->bindValue(':classe', $classe);
		$requete->bindValue(':matiere', $matiere);
		$requete->execute();
		$erreur = $requete->fetch()['erreur'];
		$requete->nextRowset();
		if($erreur == 0)
		{
			$entity = array(
				"Cours",
				"Matiere",
				"User",
				"Classe",
				"Comment"
			);
			foreach ($entity as $key) {
				if($key != "Classe" && $key != "Comment")
				{
					$mode = "\Library\Entities\\".$key;
					$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
					if($key == "Cours")
					{
						$cours = $requete->fetch();
						if(isset($cours['Message']))
						{
							$cours = $cours['Message'];
							return $cours;
						}
						$cours->setDateAjout(new \DateTime($cours->dateAjout()));
						$cours->setDateModif(new \DateTime($cours->dateModif()));
						//echo '<pre>Cours n: '.($i+1)."<br/>";print_r($cours[$i]);echo '</pre>';
					}
					else
					{
						$requete->nextRowset();
						$value = $requete->fetch();
						//echo '<pre>Objet : '.$key.' - mode : '.$mode.'</pre><pre>';print_r($value);echo '</pre>';				
						$methode = "set".$key;
						if($key == "User")
						{
							$methode = "setAuteur";
						}
						//echo '<pre>Méthode appelée :'.$methode.'</pre>';
						$cours->$methode($value);
						//echo '<pre>Cours n: '.($i+1)."<br/>";print_r($cours[$i]);echo '</pre>';
					}
				}
				else if($key == "Classe")
				{
					$entities = array(
						"Classe",
						"Session",
						"Section",
						"Matiere",
						"Professeur",
						"Eleve"
					);
					foreach ($entities as $cle) {
						$requete->nextRowset();
						$mode = "\Library\Entities\\".$cle;
						$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
						if($cle == "Classe")
						{
							$classe = $requete->fetch();
						}
						else
						{
							if ($cle == "Session" || $cle == "Section")
							{
								$value = $requete->fetch();
								$methode = 'set'.$cle;
								$classe->$methode($value);
							}
							else
							{
								$values = $requete->fetchAll();
								$methode = 'set'.$cle.'s';
								$classe->$methode($values);
							}
						}
					}
					$cours->setClasse($classe);
				}
				else if($key == "Comment")
				{
					$requete->nextRowset();
					$nombre = $requete->fetch(\PDO::FETCH_ASSOC)['Commentaires'];
					$comments = array();
					//echo '<pre><br/><br/><br/><br/><br/>Nombre de commentaires: '.$nombre.'</pre>';
					if($nombre > 0)
					{
						for ($i=0; $i < $nombre; $i++) { 
							$requete->nextRowset();
							$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\Comment");
							$comments[$i] = $requete->fetch();
							$comments[$i]->setDateCommentaire(new \DateTime($comments[$i]->dateCommentaire()));
							$requete->nextRowset();
							$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Library\Entities\User");
							$auteur = $requete->fetch();
							$comments[$i]->setAuteur($auteur);
						}
					}
					$cours->setCommentaires($comments);
				}
			}
		}
		else
		{
			$cours = $requete->fetch()['Message'];
		}
		
		return $cours;
	}
	
	public function setCount($id) {
		$requete = $this->dao->prepare('UPDATE cours
			SET count_c = count_c + 1
			WHERE id_c = :id');
			
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
	}
	
	public function getCount($id) {
		$requete = $this->dao->prepare('SELECT count_c
			FROM cours
			WHERE id_c = :id');
			
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$result = $requete->fetch();
		return $result;
	}
	
	protected function add(Cours $cours)
	{
		$requete = $this->dao->prepare('INSERT INTO cours SET id_u = :auteur, id_classe = :classe, id_m = :matiere, titre = :titre, description = :description, contenu = :contenu, dateAjout = sysdate(), dateModif = sysdate()');
		
	    $requete->bindValue(':auteur', $cours->auteur()->id());
		$requete->bindValue(':classe', $cours->classe()->id());
		$requete->bindValue(':matiere', $cours->matiere()->id());
	    $requete->bindValue(':titre', $cours->titre());
		$requete->bindValue(':description', $cours->description());
	    $requete->bindValue(':contenu', $cours->contenu());
 
	    $requete->execute();
	}
	
	protected function modify(Cours $cours)
	{
	    $requete = $this->dao->prepare('UPDATE cours SET id_m = :matiere, titre = :titre, description = :description, contenu = :contenu, dateModif = NOW() WHERE id_cours = :id');
	    $requete->bindValue(':matiere', $cours->matiere()->id());
		$requete->bindValue(':titre', $cours->titre());
		$requete->bindValue(':description', $cours->description());
		$requete->bindValue(':contenu', $cours->contenu());
		$requete->bindValue(':id', $cours->id());
	    $requete->execute();
	}
	
  	public function delete(Cours $cours)
  	{
  		$this->dao->exec('DELETE FROM cours WHERE id_cours = '.$cours['id']);
  	}
	  
	  
}