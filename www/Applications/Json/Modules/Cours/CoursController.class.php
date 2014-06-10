<?php
namespace Applications\Json\Modules\Cours;



class CoursController extends \Library\BackController
{
	public function executeListMatieres(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Liste des matières');
		$this->page->addVar('no_layout', true);
		$this->setView('index');
		$listeMatiere = $this->managers->getManagerOf('Matiere')->getListJson($request->getData('id'));

		$reponse = array();
		
		if($listeMatiere == null || count($listeMatiere) < 1)
		{
			$reponse['result'] = false;
			
		}
		else
		{
			$reponse['Matieres'] = array();
			foreach ($listeMatiere as $key) {
				$reponse['Matieres'][] = array(
					"id" => $key->id(),
					"libelle" => $key->libelle()
				);
			}
		}
		
		$reponse = json_encode($reponse);
		$this->page->addVar('json', $reponse);
	}
	
	public function executeListCours(\Library\HTTPRequest $request)
	{
		
	}
	
	public function executeAffCours(\Library\HTTPRequest $request)
	{
		
	}
}
	
	
	
?>