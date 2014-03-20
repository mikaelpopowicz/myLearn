<?php
namespace Library\Models;
 
use \Library\Entities\Session;
 
class SessionManager_PDO extends SessionManager
{
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('SELECT id_session AS id, session
			FROM session
			WHERE id_session = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Session');
     
		if ($section = $requete->fetch())
		{
			return $section;
		}
     
		return null;
	}
	
	public function getList()
	{
		$sql = 'SELECT id_session AS id, session
			FROM session
			ORDER BY session DESC';
     
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Session');
     
		$listeSession = $requete->fetchAll();
     
		$requete->closeCursor();
     
		return $listeSession;
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
		return $this->dao->query('SELECT COUNT(*) FROM session')->fetchColumn();
	}
	
	protected function add(Session $session)
	{
		$requete = $this->dao->prepare('CALL ajouter_session(:session)');
		$requete->bindValue(':session', $session->session());
		$requete->execute();
	}

	protected function modify(Session $session)
	{
		$requete = $this->dao->prepare('UPDATE session SET session = :session WHERE id_session = :id');
		$requete->bindValue(':session', $session->session());
		$requete->bindValue(':id', $session->id());
		$requete->execute();
	}

	public function delete(Session $session)
  	{
  		$this->dao->exec('DELETE FROM session WHERE id_session = '.$session['id']);
  	}
}