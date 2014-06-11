<?php
namespace Applications\Prof\Modules\Cours;

class CoursController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Liste des classes');
		$this->page->addVar('class_cours', 'active');
		$result = $this->managers->getManagerOf('Classe')->getClasses($this->app->user()->getAttribute('id'),false);
		if(isset($result) && is_array($result))
		{
			$this->app->user()->setAttribute('classes',$result);
		}
		$matiere = unserialize(base64_decode($this->app->user()->getAttribute('matiere')));
		$this->page->addVar('matiere', $matiere);
	}
	
	public function executeList_cours(\Library\HTTPRequest $request)
	{
		$matiere = unserialize(base64_decode($this->app->user()->getAttribute('matiere')));
		//echo '<pre>'.$matiere->uri().'</pre>';die();
		$result = $this->managers->getManagerOf('Matiere')->getByName($request->getData('libelle'), $this->app->user()->getAttribute('id'), $matiere->uri(),$this->app->config()->get('cours_page'), $request->getData('page'));
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
						$paginate = \Library\Pagination::getB3Pag(array(
							'delta' => 5,
							'number' => $result['pages'],
							'current' => $page,
							'url' => '/professeur/cours/'.str_replace('/','-',$classe->session()->session()).'/'.$classe->uri()
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
						$this->app->httpResponse()->redirect("/professeur/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri());
					}
				}
			}
			else if(isset($result['matiere']) && ($result['matiere'] instanceof \Library\Entities\Error))
			{
				$erreur = $result['matiere'];
			
				$this->app->user()->setFlash($erreur->type(),$erreur->message());
				$this->app->httpResponse()->redirect("/professeur/cours".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri());
			}
		}
		else if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Error))
		{
			$erreur = $result['classe'];
			
			$this->app->user()->setFlash($erreur->type(),$erreur->message());
			$this->app->httpResponse()->redirect("/professeur/cours");
		}
	}
	
	public function executeShow(\Library\HTTPRequest $request)
	{
		$matiere = unserialize(base64_decode($this->app->user()->getAttribute('matiere')));
		
		$result = $this->managers->getManagerOf('Cours')->getByName($request->getData('libelle'), $this->app->user()->getAttribute('id'), $matiere->uri(), $request->getData('cours'));
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
							$this->app->httpResponse()->redirect('/professeur/cours/'.str_replace('/','-',$classe->session()->session()).'/'.$classe->uri().'/'.$cours->uri());
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
					$this->app->httpResponse()->redirect("/professeur/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri());
				}
			}
			else if(isset($result['matiere']) && ($result['matiere'] instanceof \Library\Entities\Error))
			{
				$erreur = $result['matiere'];
			
				$this->app->user()->setFlash($erreur->type(),$erreur->message());
				$this->app->httpResponse()->redirect("/professeur/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri());
			}
		}
		else if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Error))
		{
			$erreur = $result['classe'];
			
			$this->app->user()->setFlash($erreur->type(),$erreur->message());
			$this->app->httpResponse()->redirect("/professeur/cours");
		}
	}
	
	public function executeEcrire(\Library\HTTPRequest $request)
	{
		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/professeur/mes-cours');
		}
		
		if($request->postExists('ajouter')) {
			$user = $this->managers->getManagerOf('User')->getUnique($this->app->user()->getAttribute('id'));
			$cours = new \Library\Entities\Cours(array(
				'auteur' => $user,
				'classe' => unserialize(base64_decode($request->postData('classe'))),
				'matiere' => unserialize(base64_decode($this->app->user()->getAttribute('matiere'))),
				'titre' => $request->postData('titre'),
				'description' => $request->postData('description'),
				'contenu' => $request->postData('contenu'),
				'uri' => \Library\Cleaner::getUri($request->postData('titre'))
			));
		
			if($cours->isValid()) {
				$this->managers->getManagerOf('Cours')->save($cours);
				$this->app->user()->setFlash('success','<strong>Cours enregistré !</strong>');
				$this->app->httpResponse()->redirect('/professeur/mes-cours');
			} else {
				$this->page->addVar('cours', $cours);
				$this->page->addVar('erreurs', $cours['erreurs']);
			}
		}

		$this->page->addVar('title', 'MyLearn - Ecrire un cours');
	}
	
	public function executeModifier(\Library\HTTPRequest $request)
	{
		$result = $this->managers->getManagerOf('Cours')->getUnique($request->getData('id'));
		if(($result instanceof \Library\Entities\Cours))
		{
			$cours = $result;
			
			if($cours->auteur()->id() == $this->app->user()->getAttribute('id'))
			{
				
				if($request->postExists('annuler')) {
					$this->app->httpResponse()->redirect('/professeur/mes-cours');
				}
		
				if($request->postExists('modifier')) {
					$cours = new \Library\Entities\Cours(array(
						'id' => $cours->id(),
						'matiere' => unserialize(base64_decode($this->app->user()->getAttribute('matiere'))),
						'classe' => unserialize(base64_decode($request->postData('classe'))),
						'titre' => $request->postData('titre'),
						'description' => $request->postData('description'),
						'contenu' => $request->postData('contenu'),
						'uri' => \Library\Cleaner::getUri($request->postData('titre'))
					));
				
					if($cours->isValid()) {
						$this->managers->getManagerOf('Cours')->save($cours);
						$this->app->user()->setFlash('success','<strong>Modifications enregistrées !</strong>');
						$this->app->httpResponse()->redirect('/professeur/mes-cours');
					} else {
						$this->page->addVar('cours', $cours);
						$this->page->addVar('erreurs', $cours->erreurs());
					}
				}

				$this->page->addVar('title', 'MyLearn - Modifier - '.$cours->titre());
				$this->page->addVar('cours', $cours);
			} else {
				$this->app->user()->setFlash('warning','Vous ne pouvez pas modifier ce cours car vous n\'en n\'êtes pas l\'auteur');
				$this->app->httpResponse()->redirect('/professeur/mes-cours');
			}		
		} else {
			$this->app->user()->setFlash('warning','Erreur');
			$this->app->httpResponse()->redirect('/professeur/mes-cours');
		}
	}
	
	public function executeSupprimer(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) { 
			$this->managers->getManagerOf('Cours')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('success','<strong>Suppression réussie !</strong>');
		$this->app->httpResponse()->redirect('/professeur/mes-cours');
	}
}	
?>