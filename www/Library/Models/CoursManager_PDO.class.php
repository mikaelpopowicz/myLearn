<?php
namespace Library\Models;
 
use \Library\Entities\Cours;
 
class CoursManager_PDO extends CoursManager
{
	public static function getObj($requete)
	{
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Cours');
		$result = $requete->fetch();
		$result->setDateAjout(new \DateTime($result->dateAjout()));
		$result->setDateModif(new \DateTime($result->dateModif()));
		$entities = array(
			"Eleve",
			"Comments",
			"Vue"
		);
		foreach ($entities as $key) {
			$requete->nextRowset();
			$static = '\Library\Models\\'.$key.'Manager_PDO';
			if ($key == "Eleve")
			{
				$value = $static::getObj($requete);
				$methode = 'setAuteur';
				$result->$methode($value);
			}
			else
			{
				$nb = $key == "Comments" ? $requete->fetch(\PDO::FETCH_ASSOC)['Commentaires'] : $requete->fetch(\PDO::FETCH_ASSOC)['Vues'];
				$value = array();
				if($nb > 0)
				{
					for ($i=0; $i < $nb; $i++) {
						$requete->nextRowset();
						$value[$i] = $static::getObj($requete);
					}
					$methode = $key == "Comments" ? 'setCommentaires' : 'setVues';
					$result->$methode($value);
				}
			}
			
		}
		
		return $result;
	}
	
	public function getLastFav($user)
	{
		$requete = $this->dao->prepare('CALL select_cours_lastfav(:user)');
		$requete->bindValue(':user', $user);
		$requete->execute();
		$result['fav'] = $requete->fetch(\PDO::FETCH_ASSOC)['Favorites'];
		$nba = $result['fav'];
		if($nba > 0)
		{
			$result['fav'] = array();
		
			for ($i=0; $i < $nba; $i++)
			{
				$requete->nextRowset();
				$result['classe'] = \Library\Models\ClasseManager_PDO::getObj($requete);
				$requete->nextRowset();
				$result['matiere'] = \Library\Models\MatiereManager_PDO::getObj($requete);
				$requete->nextRowset();
				$result['fav'][$i] = \Library\Models\CoursManager_PDO::getObj($requete);
				$result['fav'][$i]->setClasse($result['classe']);
				$result['fav'][$i]->setMatiere($result['matiere']);
			}
		}
		
		$requete->nextRowset();
		
		$result['last'] = $requete->fetch(\PDO::FETCH_ASSOC)['Last'];
		$nbc = $result['last'];
		if($nbc > 0)
		{
			$result['last'] = array();
		
			for ($i=0; $i < $nbc; $i++)
			{
			
				$requete->nextRowset();
				$result['classe'] = \Library\Models\ClasseManager_PDO::getObj($requete);
				$requete->nextRowset();
				$result['matiere'] = \Library\Models\MatiereManager_PDO::getObj($requete);
				//echo '<pre>';print_r($result);echo '</pre>';
				$requete->nextRowset();
				$result['last'][$i] = \Library\Models\CoursManager_PDO::getObj($requete);
				$result['last'][$i]->setClasse($result['classe']);
				$result['last'][$i]->setMatiere($result['matiere']);
			}
		}
		return $result;
	}
	
	public function getByName($libelle,$id,$mat,$titre) {
		
		$libelle = explode('/',$libelle);
		$libelle[0] = str_replace('-','/',$libelle[0]);
		$requete = $this->dao->prepare('CALL select_variable_result(:util, :session, :classe, :mat, NULL, NULL, :titre)');
		$requete->bindValue(':util', $id);
		$requete->bindValue(':classe', $libelle[1]);
		$requete->bindValue(':session', $libelle[0]);
		$requete->bindValue(':mat', $mat);
		$requete->bindValue(':titre', $titre);
		$requete->execute();
		$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
		$requete->nextRowset();

		if($erreur == 0)
		{
			$result['classe'] = \Library\Models\ClasseManager_PDO::getObj($requete);
			$requete->nextRowset();
			$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
			$requete->nextRowset();
			if($erreur == 0)
			{
				$result['matiere'] = \Library\Models\MatiereManager_PDO::getObj($requete);
				$requete->nextRowset();
				$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
				$requete->nextRowset();
				if($erreur == 0)
				{
					$result['cours'] = \Library\Models\CoursManager_PDO::getObj($requete);
				}
				else
				{
					$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
					$result['cours'] = $requete->fetch();
				}
			}
			else
			{
				$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
				$result['matiere'] = $requete->fetch();
			}
		}
		else
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result['classe'] = $requete->fetch();
		}
		$requete->closeCursor();
		//echo '<pre>';print_r($result);echo '</pre>';
		return $result;
	}
	
	public function search($query, $id)
	{
		$requete = $this->dao->prepare('CALL search_engine(:query, :id)');
		$requete->bindValue(':query', $query);
		$requete->bindValue(':id', $id);
		$requete->execute();
		$nombre = $requete->fetch(\PDO::FETCH_ASSOC)['Cours'];
		
		if($nombre > 0)
		{
			for ($i=0; $i < $nombre; $i++) { 
				$requete->nextRowset();
				$result['classe'] = \Library\Models\ClasseManager_PDO::getObj($requete);
				$requete->nextRowset();
				$result['matiere'] = \Library\Models\MatiereManager_PDO::getObj($requete);
				$requete->nextRowset();
				$result[$i] = \Library\Models\CoursManager_PDO::getObj($requete);
				$result[$i]->setClasse($result['classe']);
				$result[$i]->setMatiere($result['matiere']);
				unset($result['classe']);
				unset($result['matiere']);
			}
			return $result;
		}
		return false;
	}
	
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

	public function getListByAuthor($auteur)
	{
		$requete = $this->dao->prepare('CALL select_cours_auteur(:id)');
		$requete->bindValue(':id', $auteur);
		$requete->execute();
		$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Cours'];
		$result = array();
		for ($i=0; $i < $nb; $i++) {
			$requete->nextRowset();
			$result['classe'] = \Library\Models\ClasseManager_PDO::getObj($requete);
			$requete->nextRowset();
			$result['matiere'] = \Library\Models\MatiereManager_PDO::getObj($requete);
			$requete->nextRowset();
			$result['cours'][$i] = \Library\Models\CoursManager_PDO::getObj($requete);
			$result['cours'][$i]->setClasse($result['classe']);
			$result['cours'][$i]->setMatiere($result['matiere']);
			unset($result['classe']);
			unset($result['matiere']);
		}
		//echo '<pre>';print_r($result);echo '</pre>';die();
		$requete->closeCursor();
		return $result;
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

	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('CALL select_cours(:id, true)');
		$requete->bindValue(':id', $id);
		$requete->execute();
		
		$result['classe'] = \Library\Models\ClasseManager_PDO::getObj($requete);
		$requete->nextRowset();
		$result['matiere'] = \Library\Models\MatiereManager_PDO::getObj($requete);
		$requete->nextRowset();
		$result['cours'] = \Library\Models\CoursManager_PDO::getObj($requete);
		$result['cours']->setClasse($result['classe']);
		$result['cours']->setMatiere($result['matiere']);
		unset($result['classe']);
		unset($result['matiere']);
		
		return $result;
	}

	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM cours')->fetchColumn();
	}
	
	public function addVolume($nombre = 50)
	{
		for ($i=0; $i < $nombre; $i++) { 
			$id_a = rand(3,4);
			$id_m = rand(1,6);
			$cours = new \Library\Entities\Cours(array(
				"classe" => new \Library\Entities\Classe(array(
					"id" => 1
				)),
				"auteur" => new \Library\Entities\Eleve(array(
					"id" => $id_a
				)),
				"matiere" => new \Library\Entities\Matiere(array(
					"id" => $id_m
				)),
				"titre" => "Titre ".$i,
				"contenu" => "Contenu du cours numéro ".$i,
				"description" => "Descpription du cours numéro ".$i,
				"uri" => "contenu-du-cours-numero-".$i,
			));
			$this->add($cours);
			time_nanosleep(0, 500000000);
		}
	}
	
	protected function add(Cours $cours)
	{
		$requete = $this->dao->prepare('INSERT INTO cours SET id_u = :auteur, id_classe = :classe, id_m = :matiere, titre = :titre, uri = :uri, description = :description, contenu = :contenu, dateAjout = sysdate(), dateModif = sysdate()');
		
	    $requete->bindValue(':auteur', $cours->auteur()->id());
		$requete->bindValue(':classe', $cours->classe()->id());
		$requete->bindValue(':matiere', $cours->matiere()->id());
	    $requete->bindValue(':titre', $cours->titre());
		$requete->bindValue(':uri', $cours->uri());
		$requete->bindValue(':description', $cours->description());
	    $requete->bindValue(':contenu', $cours->contenu());
 
	    $requete->execute();
	}
	
	protected function modify(Cours $cours)
	{
	    $requete = $this->dao->prepare('UPDATE cours SET id_classe = :classe, id_m = :matiere, titre = :titre, uri = :uri, description = :description, contenu = :contenu, dateModif = NOW() WHERE id_cours = :id');
		$requete->bindValue(':classe', $cours->classe()->id());
	    $requete->bindValue(':matiere', $cours->matiere()->id());
		$requete->bindValue(':titre', $cours->titre());
		$requete->bindValue(':uri', $cours->uri());
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