<?php
namespace Applications\Json\Modules\Cours;

class CoursController extends \Library\BackController
{
	public function listeMatieres( \Library\HTTPRequest $request)
		{
			$user = $request->getData('id');
			$listeMatieres = $this->getManagerOf('Matiere')->getListEleves($user);
			
			if (count(listeMatieres)>0) 
			{
				
			}
		}	
		
	public function listeCours( \Library\HTTPRequest $request)
		{
				
		}
			
	public function afficherCours( \Library\HTTPRequest $request)
		{
			
		}
}
?>