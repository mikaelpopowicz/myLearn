<?php
namespace Applications\Frontend\Modules\Cours;
 
class CoursController extends \Library\BackController {
	
	public function executeIndex(\Library\HTTPRequest $request) {
		$this->page->addVar('title', 'MyLearn - Accueil');
		$this->page->addVar("class_accueil", "active");
	}
	
	public function executeList_classe(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Liste des classes');
		$this->page->addVar('class_cours', 'active');
	}
	
	public function executeList_cours(\Library\HTTPRequest $request)
	{
		$classe = $this->managers->getManagerOf('Classe')->getByName(urldecode($request->getData('libelle')), $this->app->user()->getAttribute('id'));
		if($classe instanceof \Library\Entities\Classe)
		{
			$matiere = $this->managers->getManagerOf('Matiere')->getByName(str_replace('-',' ',urldecode($request->getData('matiere'))),$classe->id());
			if($matiere != NULL)
			{
				$this->page->addVar('title', 'MyLearn - '.$classe->libelle().' - '.$matiere->libelle());
				$this->page->addVar('class_cours', 'active');
				$this->page->addVar('class_'.$classe->id().'_cl', 'active');
				$this->page->addVar('classe', $classe);
				$this->page->addVar('matiere', $matiere);
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>d</strong>"});</script>');
				//$this->app->httpResponse()->redirect("/cours/".str_replace('/','-',$classe->session()->session())."/".urlencode(str_replace(' ','-',$classe->libelle())));
				$this->app->httpResponse()->redirect404($this->page);
			}
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>'.$classe.'</strong>"});</script>');
			$this->app->httpResponse()->redirect("/cours");
		}

		$this->page->addVar('listeCours', "");
		$this->page->addVar('comments', "");

		
	}
	
	public function executeList_matiere(\Library\HTTPRequest $request) {
		$classe = $this->managers->getManagerOf('Classe')->getByName(urldecode($request->getData('libelle')), $this->app->user()->getAttribute('id'));
		if($classe instanceof \Library\Entities\Classe)
		{
			$this->page->addVar('title', 'MyLearn - '.$classe->libelle());
			$this->page->addVar('class_cours', 'active');
			$this->page->addVar('class_'.$classe->id().'_cl', 'active');
			$this->page->addVar('classe', $classe);
			$this->page->addVar('listeMatiere', $classe->matieres());
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>'.$classe.'</strong>"});</script>');
			$this->app->httpResponse()->redirect("/cours");
		}
		
		
	}
	
	public function executeShow(\Library\HTTPRequest $request)
	{
		$matiere = $this->managers->getManagerOf('Matiere')->getByName(urldecode($request->getData('libelle')));
		$cours = $this->managers->getManagerOf('Cours')->getUnique($request->getData('id'));
		$this->managers->getManagerOf('Cours')->setCount($cours['id']);
		
		//echo '<pre>';print_r($matiere);echo '</br>';print_r($cours);echo '</pre>';
		if (empty($matiere) || empty($cours) || $matiere['id'] != $cours['matiere']) {
			$this->app->httpResponse()->redirect404();
		} else {
			if($this->app->user()->isAuthenticated()) {
				if($request->postExists('comment')) {
					if($request->postExists('message')) {
						
						$comment = new Comment(array(
							'cours' => $cours->id(),
							'auteur' => $request->postData('byte'),
							'commentaire' => $request->postData('message')
						));
						
						if($comment->isValid()) {
							$this->managers->getManagerOf('Comments')->add($comment);
						}
					}
				}
			}
			$this->page->addVar('title', "Mika-p - ".$cours->titre());
			$this->page->addVar('class_cours', 'active');
			$this->page->addVar('class_'.urldecode($request->getData('libelle')), 'active');
			$this->page->addVar('matiere', urldecode($request->getData('libelle')));
			$this->page->addVar('cours', $cours);
			$this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($cours->id()));
			$this->page->addVar('byteController', $this->managers->getManagerOf('Byte'));
			$this->page->addVar('listeCours', $cours);
			$this->getFav();
		}		
	}

	public function getFav() {
		$this->page->addVar('coursPop', $this->managers->getManagerOf('Cours')->getPopular());
		$this->page->addVar('coursLast', $this->managers->getManagerOf('Cours')->getLast());
		$this->page->addVar('matController', $this->managers->getManagerOf('Matiere'));
	}

	public function executeEcrire(\Library\HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated()) {

			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/membre/mes-cours');
			}
		
			if($request->postExists('ajouter')) {
				$cours = new \Library\Entities\Cours(array(
					'auteur' => $this->app->user()->getAttribute('id'),
					'matiere' => $request->postData('matiere'),
					'titre' => $request->postData('titre'),
					'description' => $request->postData('description'),
					'contenu' => $request->postData('contenu')
				));
			
			if($cours->isValid()) {
				$this->managers->getManagerOf('Cours')->save($cours);
				$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "<strong>Cours enregistré !</strong>"});</script>');
				$this->app->httpResponse()->redirect('/membre/mes-cours');
			} else {
				$this->page->addVar('cours', $cours);
				$this->page->addVar('erreurs', $cours['erreurs']);
			}
		}

			$this->page->addVar('title', 'Mika-p - Ecrire un cours');
			$this->page->addVar('matieres', $this->managers->getManagerOf('Matiere')->getList());

		} else {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous devez être connecté pour accéder à cette page"});</script>');
			$this->app->httpResponse()->redirect('/');
		} 
	}

	public function executeModifier(\Library\HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated()) {

			$cours = $this->managers->getManagerOf('Cours')->getUnique($request->getData('id'));

			if($cours != NULL) {

				if($cours['auteur'] == $this->app->user()->getAttribute('username')) {
					if($request->postExists('annuler')) {
						$this->app->httpResponse()->redirect('/membre/mes-cours');
					}
			
					if($request->postExists('modifier')) {
						$cours = new \Library\Entities\Cours(array(
							'id' => $cours['id'],
							'auteur' => $this->app->user()->getAttribute('id'),
							'matiere' => $request->postData('matiere'),
							'titre' => $request->postData('titre'),
							'description' => $request->postData('description'),
							'contenu' => $request->postData('contenu')
						));
					
						if($cours->isValid()) {
							$this->managers->getManagerOf('Cours')->save($cours);
							$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "<strong>Modifications enregistrées !</strong>"});</script>');
							$this->app->httpResponse()->redirect('/membre/mes-cours');
						} else {
							$this->page->addVar('cours', $cours);
							$this->page->addVar('erreurs', $cours['erreurs']);
						}
					}

					$this->page->addVar('title', 'Mika-p - Ecrire un cours');
					$this->page->addVar('matieres', $this->managers->getManagerOf('Matiere')->getList());
					$this->page->addVar('cours', $cours);
				} else {
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous ne pouvez pas modifier ce cours car vous n\'en n\'êtes pas l\'auteur"});</script>');
					$this->app->httpResponse()->redirect('/membre/mes-cours');
				}		
			} else {
				$this->app->httpResponse()->redirect404();
			}
		} else {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous devez être connecté pour accéder à cette page"});</script>');
			$this->app->httpResponse()->redirect('/');
		}
	}

	public function executeSupprimer(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) { 
			$this->managers->getManagerOf('Cours')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/membre/mes-cours');
	}
}