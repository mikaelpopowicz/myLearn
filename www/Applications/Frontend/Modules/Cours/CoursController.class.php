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
		$classe = $this->managers->getManagerOf('Classe')->getByName(urldecode($request->getData('libelle')), $this->app->user()->getAttribute('id'));
		if($classe instanceof \Library\Entities\Classe)
		{
			$matiere = $this->managers->getManagerOf('Matiere')->getByName($this->app->key()->uriDecode($request->getData('matiere')),$classe->id());
			if($matiere != NULL)
			{
				$this->page->addVar('title', 'MyLearn - '.$classe->libelle().' - '.$matiere->libelle());
				$this->page->addVar('class_cours', 'active');
				$this->page->addVar('class_'.$classe->id().'_cl', 'active');
				$this->page->addVar('classe', $classe);
				$this->page->addVar('matiere', $matiere);
				$cours = $this->managers->getManagerOf('Cours')->getListByClasseMatiere($classe->id(),$matiere->id());
				$this->page->addVar('lesCours', $cours);
				$this->page->addVar('key', $this->app->key());
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>Cette matière n\'existe pas dans cette classe</strong>"});</script>');
				$this->app->httpResponse()->redirect('/cours/'.str_replace('/','-',$classe->session()->session()).'/'.str_replace(' ','-',$classe->libelle()));
			}
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>'.$classe.'</strong>"});</script>');
			$this->app->httpResponse()->redirect("/cours");
		}
	}
	
	public function executeList_matiere(\Library\HTTPRequest $request) {
		$classe = $this->managers->getManagerOf('Classe')->getByName(urldecode($request->getData('libelle')), $this->app->user()->getAttribute('id'));
		if($classe instanceof \Library\Entities\Classe)
		{
			$this->page->addVar('title', 'MyLearn - '.$classe->libelle());
			$this->page->addVar('class_cours', 'active');
			$this->page->addVar('class_'.$classe->id().'_cl', 'active');
			$this->page->addVar('classe', $classe);
			if(count($classe->matieres()) > 0)
			{
				$this->page->addVar('listeMatiere', $classe->matieres());
				$this->page->addVar('key', $this->app->key());
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
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>'.$classe.'</strong>"});</script>');
			$this->app->httpResponse()->redirect("/cours");
		}
		
		
	}
	
	public function executeShow(\Library\HTTPRequest $request)
	{
		$classe = $this->managers->getManagerOf('Classe')->getByName(urldecode($request->getData('libelle')), $this->app->user()->getAttribute('id'));
		if($classe instanceof \Library\Entities\Classe)
		{
			$matiere = $this->managers->getManagerOf('Matiere')->getByName($this->app->key()->uriDecode($request->getData('matiere')),$classe->id());
			if($matiere != NULL)
			{
				$titre = $this->app->key()->uriDecode($request->getData('cours'));
				$cours = $this->managers->getManagerOf('Cours')->getByNameClasseMatiere($titre,$classe->id(),$matiere->id());
				if($cours instanceof \Library\Entities\Cours)
				{
					$this->page->addVar('title', 'MyLearn - '.$cours->titre());
					$this->page->addVar('class_cours', 'active');
					$this->page->addVar('class_'.$classe->id().'_cl', 'active');
					$this->page->addVar('classe', $classe);
					$this->page->addVar('matiere', $matiere);
					$this->page->addVar('cours', $cours);
					$this->page->addVar('key', $this->app->key());
					
					if($request->postExists('comment'))
					{
						$user = $this->managers->getManagerOf('User')->getUnique($this->app->user()->getAttribute('id'));
						$comment = new \Library\Entities\Comment(array(
							"cours" => $cours,
							"auteur" => $user,
							"commentaire" => nl2br($request->postData('message'))
						));
						
						if($comment->isValid())
						{
							$this->managers->getManagerOf('Comments')->save($comment);
							$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "success", layout: "topCenter", text: "<strong>Commentaire enregistré</strong>"});</script>');
							$this->app->httpResponse()->redirect('/cours/'.str_replace('/','-',$classe->session()->session()).'/'.str_replace(' ','-',$classe->libelle())."/".$this->app->key()->uriEncode($matiere->libelle()).'/'.$this->app->key()->uriEncode($cours->titre()));
						}
						else
						{
							
						}
					}
				}
				else
				{
					$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>'.$cours.'</strong>"});</script>');
					$this->app->httpResponse()->redirect('/cours/'.str_replace('/','-',$classe->session()->session()).'/'.str_replace(' ','-',$classe->libelle())."/".$this->app->key()->uriEncode($matiere->libelle()));
				}
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>Cette matière n\'existe pas dans cette classe</strong>"});</script>');
				$this->app->httpResponse()->redirect('/cours/'.str_replace('/','-',$classe->session()->session()).'/'.str_replace(' ','-',$classe->libelle()));
			}
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "warning", layout: "top", text: "<strong>'.$classe.'</strong>"});</script>');
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
			$this->app->httpResponse()->redirect('/membre/mes-cours');
		}
		
		if($request->postExists('ajouter')) {
			$user = $this->managers->getManagerOf('User')->getUnique($this->app->user()->getAttribute('id'));
			$cours = new \Library\Entities\Cours(array(
				'auteur' => $user,
				'classe' => unserialize(base64_decode($this->app->user()->getAttribute('classes')[0])),
				'matiere' => unserialize(base64_decode($request->postData('matiere'))),
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
		
		$this->page->addVar('matieres', unserialize(base64_decode($this->app->user()->getAttribute('classes')[0]))->matieres());
	}

	public function executeModifier(\Library\HTTPRequest $request)
	{
		$cours = $this->managers->getManagerOf('Cours')->getUnique($request->getData('id'));
		if($cours instanceof \Library\Entities\Cours) {
			if($cours->auteur()->id() == $this->app->user()->getAttribute('id')) {
				$this->page->addVar('matieres', $cours->classe()->matieres());
				
				if($request->postExists('annuler')) {
					$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
				}
		
				if($request->postExists('modifier')) {
					$cours = new \Library\Entities\Cours(array(
						'id' => $cours->id(),
						'matiere' => unserialize(base64_decode($request->postData('matiere'))),
						'titre' => $request->postData('titre'),
						'description' => $request->postData('description'),
						'contenu' => $request->postData('contenu')
					));
				
					if($cours->isValid()) {
						$this->managers->getManagerOf('Cours')->save($cours);
						$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "success", layout: "topCenter", text: "<strong>Modifications enregistrées !</strong>"});</script>');
						$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
					} else {
						$this->page->addVar('cours', $cours);
						$this->page->addVar('erreurs', $cours->erreurs());
					}
				}

				$this->page->addVar('title', 'Mika-p - Modifier - '.$cours->titre());
				$this->page->addVar('cours', $cours);
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous ne pouvez pas modifier ce cours car vous n\'en n\'êtes pas l\'auteur"});</script>');
				$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
			}		
		} else {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "'.$cours.'"});</script>');
			$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
		}
	}

	public function executeSupprimer(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) { 
			$this->managers->getManagerOf('Cours')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/mon-compte/mes-cours');
	}
}