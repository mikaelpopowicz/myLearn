<?php
namespace Applications\Json\Modules\Cours;

<<<<<<< HEAD
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
=======


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
		$this->page->addVar('title', 'Liste des cours de la matiere '.$request->getData('matiere'));
		$this->page->addVar('no_layout', true);
		$this->setView('index');
		$cours = $this->managers->getManagerOf('Cours')->getListJson($request->getData('id'),$request->getData('matiere'));
		$reponse = array();
		
		if($cours == null || count($cours) < 1)
		{
			$reponse['result'] = false;
		}
		else
		{
			$reponse['Cours'] = array();
			foreach ($cours as $cr) {
				$reponse['Cours'][] = array(
					"id" => $cr->id(),
					"titre" => $cr->titre(),
					"description" => $cr->description(),
					"date" => $cr->dateAjout()->format('d/m/Y'),
					"auteur" => $cr->auteur()->nom().' '.$cr->auteur()->prenom(),
					"classe" => $cr->classe()->libelle().' - '.$cr->classe()->session()->session()
				);
			}
		}
		$reponse = json_encode($reponse);
		$this->page->addVar('json', $reponse);
	}
	
	public function executeAffCours(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Le cours '.$request->getData('cours'));
		$this->page->addVar('no_layout', true);
		$this->setView('index');
		$cours = $this->managers->getManagerOf('Cours')->getUnique($request->getData('cours'));
		$reponse = array();
		
		if($cours instanceof \Library\Entities\Cours)
		{
			$reponse['Cours'] = array(
				"id" => $cours->id(),
				"titre" => $cours->titre(),
				"contenu" => $cours->contenu(),
				"date" => $cours->dateAjout()->format('d/m/Y'),
				"auteur" => $cours->auteur()->nom().' '.$cours->auteur()->prenom(),
				"classe" => $cours->classe()->libelle().' - '.$cours->classe()->session()->session()
			);
		}
		else
		{
			$reponse['result'] = false;
		}
		$reponse = json_encode($reponse);
		$this->page->addVar('json', $reponse);
	}
}
	
	
	
>>>>>>> mikael
?>