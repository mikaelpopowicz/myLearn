<?php
namespace Library\Models;
 
use \Library\Entities\Classe;
 
class ClasseManager_PDO extends ClasseManager
{
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('CALL select_class(:id)');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		
		$entity = array(
			"Classe",
			"Session",
			"Section",
			"Matiere",
			"Professeur",
			"Eleve"
		);
		
		foreach ($entity as $key) {
			$mode = "\Library\Entities\\".$key;
			$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
			if($key == "Classe")
			{
				$classe = $requete->fetch();
			}
			else
			{
				$requete->nextRowset();
				if ($key == "Session" || $key == "Section")
				{
					$value = $requete->fetch();
					$methode = 'set'.$key;
					$classe->$methode($value);
				}
				else
				{
					$values = $requete->fetchAll();
					$methode = 'set'.$key.'s';
					$classe->$methode($values);
				}
			}
		}
		return $classe;
	}
	
	public function getByName($name,$id)
	{
		$name = explode('/',$name);
		$name[0] = str_replace('-','/',$name[0]);
		$name[1] = str_replace('-',' ',$name[1]);
		//echo "<pre>";print_r($name);echo "</pre>";
		$requete = $this->dao->prepare('CALL select_class_session_user(:name, :session, :id)');
		$requete->bindValue(':name', $name[1]);
		$requete->bindValue(':session', $name[0]);
		$requete->bindValue(':id', $id);
		$requete->execute();
		$erreur = $requete->fetch()['erreur'];
		$requete->nextRowset();
		if($erreur == 0)
		{
			$entity = array(
				"Classe",
				"Session",
				"Section",
				"Matiere",
				"Professeur",
				"Eleve"
			);
		
			foreach ($entity as $key) {
				$mode = "\Library\Entities\\".$key;
				$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
				if($key == "Classe")
				{
					$classe = $requete->fetch();
				}
				else
				{
					$requete->nextRowset();
					if ($key == "Session" || $key == "Section")
					{
						$value = $requete->fetch();
						$methode = 'set'.$key;
						$classe->$methode($value);
					}
					else
					{
						$values = $requete->fetchAll();
						$methode = 'set'.$key.'s';
						$classe->$methode($values);
					}
				}
			}
		}
		else
		{
			$classe = $requete->fetch()['Message'];
		}
		
		return $classe;
	}
	
	public function getList($id)
	{
		$requete = $this->dao->prepare('CALL select_classes(:id)');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
		$nombre = $requete->fetch()['Classes'];
		$listeClasse = array();
		if($nombre > 0)
		{
			$entity = array(
				"Classe",
				"Session",
				"Section",
				"Matiere",
				"Professeur",
				"Eleve"
			);
			
			for($i = 0; $i < $nombre; $i++)
			{
				foreach ($entity as $key) {
					$mode = "\Library\Entities\\".$key;
					$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $mode);
					$requete->nextRowset();
					if($key == "Classe")
					{
						$classe = $requete->fetch();
					}
					else
					{
						if ($key == "Session" || $key == "Section")
						{
							$value = $requete->fetch();
							$methode = 'set'.$key;
							$classe->$methode($value);
						}
						else
						{
							$values = $requete->fetchAll();
							$methode = 'set'.$key.'s';
							$classe->$methode($values);
						}
					}
				}
				$listeClasse[] = $classe;
			}
		}
		return $listeClasse;
	}

	public function enCours()
	{
		$sql = 'SELECT trouver_session() AS encours';
		$requete = $this->dao->query($sql);
		if($result = $requete->fetch())
		{
			return $result['encours'];
		}
		return null;
	}

	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM classe')->fetchColumn();
	}
	
	protected function add(Classe $classe)
	{
		$requete = $this->dao->prepare('INSERT INTO classe SET id_session = :session, id_section = :section, libelle = :libelle');
		$requete->bindValue(':session', $classe->session()->id());
		$requete->bindValue(':section', $classe->section()->id());
		$requete->bindValue(':libelle', $classe->libelle());
		$requete->execute();
	}

	protected function modify(Classe $classe)
	{
		$requete = $this->dao->prepare('UPDATE classe SET id_session = :session, id_section = :section, libelle = :libelle WHERE id_classe = :id');
		$requete->bindValue(':session', $classe->session()->id());
		$requete->bindValue(':section', $classe->section()->id());
		$requete->bindValue(':libelle', $classe->libelle());
		$requete->bindValue(':id', $classe->id());
		$requete->execute();
	}

	public function delete(Classe $classe)
  	{
  		$this->dao->exec('DELETE FROM classe WHERE id_classe = '.$classe['id']);
  	}
}