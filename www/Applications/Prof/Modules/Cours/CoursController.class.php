<?php
namespace Applications\Prof\Modules\Cours;

class CoursController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		
	}
	
	public function executeList_cours(\Library\HTTPRequest $request)
	{
		$result = $this->managers->getManagerOf('Matiere')->getByName($request->getData('libelle'), $this->app->user()->getAttribute('id'), unserialize(base64_decode($this->app->user()->getAttribute('matiere')))->uri(),$this->app->config()->get('cours_page'), $request->getData('page'));
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
						$paginate = \Library\Pagination::toString(array(
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
						$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "'.$erreur->type().'", layout: "top", text: "<strong>'.$erreur->message().'</strong>"});</script>');
						$this->app->httpResponse()->redirect("/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri().'/'.$matiere->uri());
					}
				}
			}
			else if(isset($result['matiere']) && ($result['matiere'] instanceof \Library\Entities\Error))
			{
				$erreur = $result['matiere'];
			
				$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "'.$erreur->type().'", layout: "top", text: "<strong>'.$erreur->message().'</strong>"});</script>');
				$this->app->httpResponse()->redirect("/cours/".str_replace('/','-',$classe->session()->session()).'/'.$classe->uri());
			}
		}
		else if(isset($result['classe']) && ($result['classe'] instanceof \Library\Entities\Error))
		{
			$erreur = $result['classe'];
			
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "'.$erreur->type().'", layout: "top", text: "<strong>'.$erreur->message().'</strong>"});</script>');
			$this->app->httpResponse()->redirect("/cours");
		}
	}
}	
?>