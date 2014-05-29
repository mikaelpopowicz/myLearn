<?php
namespace Library\Models;

use \Library\Entities\Crypt;
 
class CryptManager_PDO extends \Library\Models\CryptManager
{
	public function getUnique($token)
	{
		$requete = $this->dao->prepare('SELECT token AS id, message, cle
			FROM crypt
			WHERE token = :token');
		$requete->bindValue(':token', $token);
		$requete->execute();
     
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Crypt');
     
		if ($crypt = $requete->fetch())
		{
			return $crypt;
		}
     
		return null;
	}
	
	public function add(Crypt $crypt)
	{
		$requete = $this->dao->prepare('INSERT INTO crypt SET token = :token, message = :message, cle = :cle');
		$requete->bindValue(':token', $crypt->id());
		$requete->bindValue(':message', $crypt->message());
		$requete->bindValue(':cle', $crypt->cle());
		$requete->execute();
	}
}