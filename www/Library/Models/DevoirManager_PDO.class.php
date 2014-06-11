<?php
namespace Library\Models;
use \Library\Entities\Devoir;
class DevoirManager_PDO extends DevoirManager
{
	public static function getObj($requete)
	{
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Devoir');
		$result = $requete->fetch();
		$result->setDateDevoir(new \DateTime($result->dateDevoir()));
		$result->setDateMax(new \DateTime($result->dateMax()));
		$entities = array(
			"Classe",
			"Professeur",
			"Piece",
			"Rendu"
		);
		foreach ($entities as $key) {
			$requete->nextRowset();
			$static = '\Library\Models\\'.$key.'Manager_PDO';
			if ($key == "Classe" || $key == "Professeur")
			{
				$value = $static::getObj($requete);
				$methode = 'set'.$key;
				$result->$methode($value);
			}
			else if($key == "Piece")
			{
				$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Pieces jointes'];
				if($nb > 0)
				{
					$requete->nextRowset();
					$value = $static::getObj($requete, 'Groups');
					$methode = 'setPieces';
					$result->$methode($value);
				}
			}
			else
			{
				$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Cibles'];
				if($nb == "unique")
				{
					$requete->nextRowset();
					$value = $static::getObj($requete);
					$methode = 'setRendus';
					$result->$methode($value);
				}
				else
				{
					$value = array();
					if($nb > 0)
					{
						for ($i=0; $i < $nb; $i++) {
							$requete->nextRowset();
							$value[$i] = $static::getObj($requete);
						}
						$methode = 'setRendus';
						$result->$methode($value);
					}
				}
			}
		}
		return $result;
		
	}
	
	public function getList($id,$prof)
	{
		$requete = $this->dao->prepare('CALL select_devoirs(:id, :prof)');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->bindValue(':prof', $prof);
		$requete->execute();
		$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Devoirs'];
		if($nb > 0)
		{
			$result = array();
			for ($i=0; $i < $nb; $i++) { 
				$requete->nextRowset();
				$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
				$requete->nextRowset();
				if($erreur == 0)
				{
					$result[] = \Library\Models\DevoirManager_PDO::getObj($requete);
				}
			}
			return $result;
		}     
		return null;
	}

	public function getUnique($id, $user, $prof, $piece, $jointe)
	{
		$requete = $this->dao->prepare('CALL select_devoir(:id, :user, :prof, :piece, :jointe)');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->bindValue(':user', $user, \PDO::PARAM_INT);
		$requete->bindValue(':prof', $prof);
		$requete->bindValue(':piece', $piece);
		$requete->bindValue(':jointe', $jointe);
		$requete->execute();
		$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
		$requete->nextRowset();
		if($erreur == 0)
		{
			$result = \Library\Models\DevoirManager_PDO::getObj($requete);
			if($piece != NULL && ($jointe == true || $jointe == false))
			{
				$requete->nextRowset();
				$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
				$requete->nextRowset();
				if($erreur == 0)
				{
					$piece = \Library\Models\PieceManager_PDO::getObj($requete);
				}
				else
				{
					$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
					$piece = $requete->fetch();
				}
				$devoir = $result;
				$result = array(
					"devoir" => $devoir,
					"piece" => $piece
				);
			}
		}
		else
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result = $requete->fetch();
		}
		//echo '<pre>';print_r($result);die("</pre>");
		return $result;
	}

	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM devoir')->fetchColumn();
	}

	protected function add(Devoir $devoir)
	{
		$requete = $this->dao->prepare('CALL ajouter_devoir(:prof, :classe, :lib, :enonce, :dateMax)');
		
	    $requete->bindValue(':prof', $devoir->professeur()->id());
		$requete->bindValue(':classe', $devoir->classe()->id());
		$requete->bindValue(':lib', $devoir->libelle());
	    $requete->bindValue(':enonce', $devoir->enonce());
	    $requete->bindValue(':dateMax', $devoir->dateMax()->format('Y-m-d'));
	    $requete->execute();
		$erreur = $requete->fetch(\PDO::FETCH_ASSOC)['erreur'];
		$requete->nextRowset();
		if($erreur == 0)
		{
			$result = \Library\Models\DevoirManager_PDO::getObj($requete);
		}
		else
		{
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Error');
			$result = $requete->fetch();
		}
		//echo '<pre>';print_r($result);echo '</pre>';
		return $result;
	}
	
	protected function modify(Devoir $devoir)
	{
	    $requete = $this->dao->prepare('CALL up_devoir(:id, :lib, :enonce, :dateMax, :actif)');
		$requete->bindValue(':id', $devoir->id());
		$requete->bindValue(':lib', $devoir->libelle());
	    $requete->bindValue(':enonce', $devoir->enonce());
	    $requete->bindValue(':dateMax', $devoir->dateMax()->format('Y-m-d'));
		$requete->bindValue(':actif', $devoir->active());
	    $requete->execute();
	}
	
	
  	public function delete(Devoir $devoir)
  	{
  		$this->dao->exec('DELETE FROM devoir WHERE id_d = '.$devoir['id']);
  	} 
}