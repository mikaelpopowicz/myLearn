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
		$this->page->addVar('key', $this->app->key());
	}
	
	public function executeList_cours(\Library\HTTPRequest $request)
	{
		$result = $this->managers->getManagerOf('Matiere')->getByName($request->getData('libelle'), $this->app->user()->getAttribute('id'), $request->getData('matiere'),$this->app->config()->get('cours_page'), $request->getData('page'));
		$this->page->addVar('special', $this->managers->getManagerOf('Cours')->getLastFav($this->app->user()->getAttribute('id')));

		if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Classe))
		{
			$classe = $result['classe'];
			
			if(isset($result['matiere']) && ($result['matiere'] instanceof \Library\Entities\Matiere))
			{
				$matiere = $result['matiere'];
				
				$this->page->addVar('title', 'MyLearn - '.$classe->libelle().' - '.$matiere->libelle());
				$this->page->addVar('class_cours', 'active');
				$this->page->addVar('class_'.$classe->id().'_cl', 'active');
				$this->page->addVar('classe', $classe);
				$this->page->addVar('matiere', $matiere);
				
				if(isset($result['cours']) && is_array($result['cours']))
				{
					$cours = $result['cours'];
					
					$page = $request->getData('page');
					$page = str_replace('_','',$page);
					$page = !empty($page) && $page > 1 ? $page : 1;
					
					if(isset($result['pages']) && $result['pages'] > 1)
					{
						$paginate = \Library\Pagination::getFrontThemePag(array(
							'delta' => 5,
							'number' => $result['pages'],
							'current' => $page,
							'url' => '/cours/'.str_replace('/','-',$classe->session()->session()).'/'.$classe->uri().'/'.$matiere->uri()
						));
						$this->page->addVar('pagination', $paginate);
					}
					
					
					$this->page->addVar('lesCours', $cours);
				}
				else if(isset($result['cours']) && ($result['cours'] instanceof \Library\Entities\Error))
				{
					$erreur = $result['cours'];
					
					if($erreur->code() == "CR_NOC")
					{
						$this->page->addVar('erreur', $erreur);
					}
					else
					{
						$this->app->user()->setFlash($erreur->type(),$erreur->message());
						$this->app->httpResponse()->redirect("/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri().'/'.$matiere->uri());
					}
				}
			}
			else if(isset($result['matiere']) && ($result['matiere'] instanceof \Library\Entities\Error))
			{
				$erreur = $result['matiere'];
			
				$this->app->user()->setFlash($erreur->type(),$erreur->message());
				$this->app->httpResponse()->redirect("/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri());
			}
		}
		else if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Error))
		{
			$erreur = $result['classe'];
			
			$this->app->user()->setFlash($erreur->type(),$erreur->message());
			$this->app->httpResponse()->redirect("/cours");
		}
	}
	
	public function executeList_matiere(\Library\HTTPRequest $request) {
		$result = $this->managers->getManagerOf('Classe')->getByName($request->getData('libelle'), $this->app->user()->getAttribute('id'));
		if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Classe))
		{
			$classe = $result['classe'];
			
			$this->page->addVar('title', 'MyLearn - '.$classe->libelle());
			$this->page->addVar('class_cours', 'active');
			$this->page->addVar('class_'.$classe->id().'_cl', 'active');
			$this->page->addVar('classe', $classe);
			if(count($classe->matieres()) > 0)
			{
				$this->page->addVar('listeMatiere', $classe->matieres());
			}
			else
			{
				$this->app->message()->setSujet("Aucune matière n'a été assignée à votre classe");
				$this->app->message()->setCode("503");
				$this->app->message()->setMessage("Veuillez réssayer ultérieurement");
				$this->app->message()->setIcone(\Library\Message::ICO_CONF);
				$this->page->addVar('message', $this->app->message()->toString());
			}
		}
		else if(isset($result['erreur']) && ($result['erreur'] instanceof \Library\Entities\Error))
		{
			$erreur = $result['erreur'];
			
			$this->app->user()->setFlash($erreur->type(),$erreur->message());
			$this->app->httpResponse()->redirect("/cours");
		}
	}
	
	public function executeShow(\Library\HTTPRequest $request)
	{
		$result = $this->managers->getManagerOf('Cours')->getByName($request->getData('libelle'), $this->app->user()->getAttribute('id'), $request->getData('matiere'), $request->getData('cours'));
		$this->page->addVar('special', $this->managers->getManagerOf('Cours')->getLastFav($this->app->user()->getAttribute('id')));
		
		if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Classe))
		{
			$classe = $result['classe'];
			
			if(isset($result['matiere']) && ($result['matiere'] instanceof \Library\Entities\Matiere))
			{
				$matiere = $result['matiere'];
				
				$this->page->addVar('title', 'MyLearn - '.$classe->libelle().' - '.$matiere->libelle());
				$this->page->addVar('class_cours', 'active');
				$this->page->addVar('class_'.$classe->id().'_cl', 'active');
				$this->page->addVar('classe', $classe);
				$this->page->addVar('matiere', $matiere);
				
				if(isset($result['cours']) && ($result['cours'] instanceof \Library\Entities\Cours))
				{
					$cours = $result['cours'];
					$this->page->addVar('cours', $cours);
					
					if($request->postExists('comment'))
					{
						$user = $this->managers->getManagerOf('User')->getUnique($this->app->user()->getAttribute('id'));
						$comment = new \Library\Entities\Comment(array(
							"cours" => $cours,
							"auteur" => $user,
							"commentaire" => htmlspecialchars(nl2br($request->postData('message')))
						));
						
						if($comment->isValid())
						{
							$this->managers->getManagerOf('Comments')->save($comment);
							$this->app->user()->setFlash('success','<strong>Commentaire enregistré</strong>');
							$this->app->httpResponse()->redirect('/cours/'.str_replace('/','-',$classe->session()->session()).'/'.$classe->uri()."/".$matiere->uri().'/'.$cours->uri());
						}
						else
						{
							
						}
					}
					
				}
				else if(isset($result['cours']) && ($result['cours'] instanceof \Library\Entities\Error))
				{
					$erreur = $result['cours'];

					$this->app->user()->setFlash($erreur->type(),$erreur->message());
					$this->app->httpResponse()->redirect("/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri().'/'.$matiere->uri());
				}
			}
			else if(isset($result['matiere']) && ($result['matiere'] instanceof \Library\Entities\Error))
			{
				$erreur = $result['matiere'];
			
				$this->app->user()->setFlash($erreur->type(),$erreur->message());
				$this->app->httpResponse()->redirect("/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri());
			}
		}
		else if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Error))
		{
			$erreur = $result['classe'];
			
			$this->app->user()->setFlash($erreur->type(),$erreur->message());
			$this->app->httpResponse()->redirect("/cours");
		}
	}

	public function getFav() {
		$this->page->addVar('coursPop', $this->managers->getManagerOf('Cours')->getPopular());
		$this->page->addVar('coursLast', $this->managers->getManagerOf('Cours')->getLast());
		$this->page->addVar('matController', $this->managers->getManagerOf('Matiere'));
	}

	public function executeEcrire(\Library\HTTPRequest $request)
	{
		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
		}
		
		if($request->postExists('ajouter')) {
			$user = $this->managers->getManagerOf('User')->getUnique($this->app->user()->getAttribute('id'));
			$cours = new \Library\Entities\Cours(array(
				'auteur' => $user,
				'classe' => unserialize(base64_decode($request->postData('classe'))),
				'matiere' => unserialize(base64_decode($request->postData('matiere'))),
				'titre' => $request->postData('titre'),
				'description' => $request->postData('description'),
				'contenu' => $request->postData('contenu'),
				'uri' => \Library\Cleaner::getUri($request->postData('titre'))
			));
		
			if($cours->isValid()) {
				$this->managers->getManagerOf('Cours')->save($cours);
				$this->app->user()->setFlash('success','<strong>Cours enregistré !</strong>');
				$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
			} else {
				$this->page->addVar('cours', $cours);
				$this->page->addVar('erreurs', $cours['erreurs']);
			}
		}

		$this->page->addVar('title', 'MyLearn - Ecrire un cours');
		
		$this->page->addVar('matieres', unserialize(base64_decode($this->app->user()->getAttribute('classes')[0]))->matieres());
	}

	public function executeModifier(\Library\HTTPRequest $request)
	{
		$result = $this->managers->getManagerOf('Cours')->getUnique($request->getData('id'));
		if($result instanceof \Library\Entities\Cours)
		{
			$cours = $result;
			
			if($cours->auteur()->id() == $this->app->user()->getAttribute('id'))
			{
				$this->page->addVar('matieres', $cours->classe()->matieres());
				
				if($request->postExists('annuler')) {
					$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
				}
		
				if($request->postExists('modifier')) {
					$cours = new \Library\Entities\Cours(array(
						'id' => $cours->id(),
						'classe' => unserialize(base64_decode($request->postData('classe'))),
						'matiere' => unserialize(base64_decode($request->postData('matiere'))),
						'titre' => $request->postData('titre'),
						'description' => $request->postData('description'),
						'contenu' => $request->postData('contenu'),
						'uri' => \Library\Cleaner::getUri($request->postData('titre'))
					));
				
					if($cours->isValid()) {
						$this->managers->getManagerOf('Cours')->save($cours);
						$this->app->user()->setFlash('success','<strong>Modifications enregistrées !</strong>');
						$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
					} else {
						$this->page->addVar('cours', $cours);
						$this->page->addVar('erreurs', $cours->erreurs());
					}
				}

				$this->page->addVar('title', 'MyLearn - Modifier - '.$cours->titre());
				$this->page->addVar('cours', $cours);
			} else {
				$this->app->user()->setFlash('warning','Vous ne pouvez pas modifier ce cours car vous n\'en n\'êtes pas l\'auteur');
				$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
			}		
		} else {
			$this->app->user()->setFlash('warning',$result);
			$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
		}
	}

	public function executeSupprimer(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) { 
			$this->managers->getManagerOf('Cours')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('success','<strong>Suppression réussie !</strong>');
		$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
	}
}