<?php
namespace Library\Models;

use \Library\Entities\LogCon;
 
class LogConManager_PDO extends \Library\Models\LogConManager
{
	public function getObj($requete)
	{
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\LogCon');
		$result = $requete->fetch();
		$result->setDateConnexion(new \DateTime($result->dateConnexion()));
		$requete->nextRowSet();
		$user = $requete->fetch(\PDO::FETCH_ASSOC)["User"];
		if($user == 1)
		{
			$requete->nextRowset();
			$result->setUser(\Library\Models\UserManager_PDO::getObj($requete));
		}
		switch ($result->etat()) {
			case 'Mauvais mot de passe':
			case 'Compte non activé':
				$result->setClasse('warning');
				break;
				
			case 'Mauvais login':
				$result->setClasse('danger');
				break;
			
			default:
				$result->setClasse('success');
				break;
		}
		return $result;
	}
	
	public function getList()
	{
		$requete = $this->dao->prepare('CALL select_logs_con()');
		$requete->execute();
		$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Logs'];
		$result = array();
		if($nb > 0)
		{
			for ($i=0; $i < $nb; $i++) {
				$requete->nextRowset();
				$result[] = \Library\Models\LogConManager_PDO::getObj($requete);
			}
		}
		return $result;
	}
}