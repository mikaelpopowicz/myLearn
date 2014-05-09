<?php
namespace Library\Models;
 
use \Library\Entities\Matiere;
 
class MatiereManager_PDO extends MatiereManager
{
	public static function getObj($requete, $mode = 'Alone')
	{		
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
		
		if($mode == 'Alone')
		{
			$result = $requete->fetch();
		}
		else if ($mode == 'Groups')
		{
			$result = $requete->fetchAll();
		}
		
		return $result;
	}
	
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_m AS id, libelle, icon
			FROM matiere
			WHERE id_m = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
     
		if ($matiere = $requete->fetch())
		{
			return $matiere;
		}
     
		return null;
	}
	
	public function getList()
	{
		$sql = 'SELECT id_m as id, libelle, icon
			FROM matiere
			ORDER BY libelle';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
     
		$listeMatiere = $requete->fetchAll();
     
		$requete->closeCursor();
     
		return $listeMatiere;
	}
	
	public function getListNone($classe)
	{
		$requete = $this->dao->prepare('SELECT id_m AS id, libelle, icon
										FROM matiere
										WHERE id_m NOT IN (
											SELECT id_m
											FROM assigner
											WHERE id_classe = :classe)
										');
		$requete->bindValue(':classe', $classe);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
		$listeMatiere = $requete->fetchAll();
		$requete->closeCursor();
		return $listeMatiere;
	}
	
	public function getListOf($classe)
	{
		$requete = $this->dao->prepare('SELECT m.id_m AS id, m.libelle, m.icon
										FROM matiere m
										INNER JOIN assigner c ON c.id_m = m.id_m
										WHERE c.id_classe = :classe');
		$requete->bindValue(':classe', $classe);
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Matiere');
		$listeMatiere = $requete->fetchAll();
		$requete->closeCursor();
		return $listeMatiere;
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM matiere')->fetchColumn();
	}

	public function getCountCours($id) {
		return $this->dao->query('SELECT COUNT(id_c) FROM cours WHERE id_m = '.$id)->fetchColumn();
	}
	
	
	
	public function getByName($libelle,$id,$mat,$qte,$page) {
		
		$libelle = explode('/',$libelle);
		$libelle[0] = str_replace('-','/',$libelle[0]);
		$page = str_replace('_','',$page);
		$page = !empty($page) && $page > 1 ? $page : 1;
		$requete = $this->dao->prepare('CALL select_variable_result(:util, :session, :classe, :mat, :qte, :page, NULL)');
		$requete->bindValue(':util', $id);
		$requete->bindValue(':classe', $libelle[1]);
		$requete->bindValue(':session', $libelle[0]);
		$requete->bindValue(':mat', $mat);
		$requete->bindValue(':qte', $qte);
		$requete->bindValue(':page', $page);
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
					$result['pages'] = $requete->fetch(\PDO::FETCH_ASSOC)['Pages'];
					$requete->nextRowset();
					$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Cours'];
					for ($i=0; $i < $nb; $i++)
					{
						$requete->nextRowset();
						$result['cours'][] = \Library\Models\CoursManager_PDO::getObj($requete);
					}
					
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
		return $result;
	}
	
	public function addVolume($number = 10000)
	{
		$matiere = new \Library\Entities\Matiere(array(
			"libelle" => "Test",
			"uri" => "test",
			"icon" => "fa fa-code"
		));
		for ($i=0; $i < $number; $i++) { 
			$requete = $this->dao->prepare('INSERT INTO matiere SET libelle = :libelle, uri = :uri, icon = :icon');
			$requete->bindValue(':libelle', $matiere->libelle());
			$requete->bindValue(':uri', $matiere->uri());
			$requete->bindValue(':icon', $matiere->icon());
			$requete->execute();
		}
	}
	
	protected function add(Matiere $matiere)
	{
		$requete = $this->dao->prepare('INSERT INTO matiere SET libelle = :libelle, uri = :uri, icon = :icon');
		$requete->bindValue(':libelle', $matiere->libelle());
		$requete->bindValue(':uri', $matiere->uri());
		$requete->bindValue(':icon', $matiere->icon());
		$requete->execute();
	}

	protected function modify(Matiere $matiere)
	{
		$requete = $this->dao->prepare('UPDATE matiere SET libelle = :libelle, uri = :uri, icon = :icon WHERE id_m = :id');
		$requete->bindValue(':libelle', $matiere->libelle());
		$requete->bindValue(':uri', $matiere->uri());
		$requete->bindValue(':icon', $matiere->icon());
		$requete->bindValue(':id', $matiere->id());
		$requete->execute();
	}

	public function delete(Matiere $matiere)
  	{
  		$this->dao->exec('DELETE FROM matiere WHERE id_m = '.$matiere['id']);
  	}
}