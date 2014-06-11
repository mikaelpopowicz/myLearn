<?php
namespace Library\Models;

use \Library\Entities\Rendu;
 
class RenduManager_PDO extends \Library\Models\RenduManager
{
	public static function getObj($requete, $mode = 'Alone')
	{
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Rendu');
		$result = $requete->fetch();
		$entities = array(
			"Eleve",
			"Piece"
		);
		foreach ($entities as $key) {
			$requete->nextRowset();
			$static = '\Library\Models\\'.$key.'Manager_PDO';
			if ($key == "Eleve")
			{
				$value = $static::getObj($requete);
				$methode = 'set'.$key;
				$result->$methode($value);
			}
			else if($key == "Piece")
			{
				$nb = $requete->fetch(\PDO::FETCH_ASSOC)['Pieces rendues'];
				if($nb > 0)
				{
					$requete->nextRowset();
					$value = $static::getObj($requete, 'Groups');
					$methode = 'setPieces';
					$result->$methode($value);
				}
			}
		}
		
		return $result;
	}
}
?>