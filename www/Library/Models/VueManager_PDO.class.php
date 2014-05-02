<?php
namespace Library\Models;

use \Library\Entities\Vue;
 
class VueManager_PDO extends \Library\Models\VueManager
{
	public static function getObj($requete, $mode = 'Alone')
	{
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Vue');
		
		if($mode == 'Alone')
		{
			$result = $requete->fetch();
			$requete->nextRowset();
			$result->setDateVue(new \DateTime($result->dateVue()));
			$result->setVisiteur(\Library\Models\EleveManager_PDO::getObj($requete));
			
		}
		else if ($mode == 'Groups')
		{
			$result = $requete->fetchAll();
			foreach ($result as $vue)
			{
				$vue->setDateVue(new \DateTime($vue->dateVue()));
			}
		}
		
		return $result;
	}
}
?>