<?php
namespace Library\Models;
 
use \Library\Entities\Section;
 
class SectionManager_PDO extends SectionManager
{
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_section AS id, id_u AS admin, libelle
			FROM section
			WHERE id_section = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Section');
     
		if ($section = $requete->fetch())
		{
			return $section;
		}
     
		return null;
	}
	
	public function getList()
	{
		$sql = 'SELECT id_section AS id, id_u AS admin, libelle
			FROM section
			ORDER BY libelle';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Section');
     
		$listeSection = $requete->fetchAll();
     
		$requete->closeCursor();
     
		return $listeSection;
	}
	
	protected function add(Section $section)
	{
		$requete = $this->dao->prepare('INSERT INTO section SET libelle = :libelle, id_u = :admin');
		$requete->bindValue(':libelle', $section->libelle());
		$requete->bindValue(':admin', $section->admin());
		$requete->execute();
	}

	protected function modify(Section $section)
	{
		$requete = $this->dao->prepare('UPDATE section SET libelle = :libelle, id_u = :admin WHERE id_section = :id');
		$requete->bindValue(':libelle', $section->libelle());
		$requete->bindValue(':admin', $section->admin());
		$requete->bindValue(':id', $section->id());
		$requete->execute();
	}

	public function delete(Section $section)
  	{
  		$this->dao->exec('DELETE FROM section WHERE id_section = '.$section['id']);
  	}
}