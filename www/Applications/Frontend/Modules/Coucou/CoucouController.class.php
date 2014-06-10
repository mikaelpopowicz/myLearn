<?php  
namespace Applications\Frontend\Modules\Coucou;

class CoucouController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$valeur = 'quelque chose';
		$this->page->addVar('test',$valeur);
	}
	public function executeTest(\Library\HTTPRequest $request)
	{
		$test = " je fais un test ";
		$this->page->addVar('test',$test);
		
		$matieres = $this->managers->getManagerOf('Matiere')->getList();
		$this->page->addVar('liste',$matieres);
	}
	public function executeListeProf(\Library\HTTPRequest $request)
	{
		$listeprof = $this->managers->getManagerOf('Professeur')->getList();
		$this->page->addVar('liste',$listeprof);
		
		$id = "4";
		$lib = "Un libelle";
		$icon = "une icone";
		
		$monPremierObjet = new \Library\Entities\Matiere(array(
			"id" => $id,
			"libelle" => $lib,
			"icon" => $icon
		));
		
		$this->page->addVar('test', $monPremierObjet);
	}
}


	
	
	
	
	
?>