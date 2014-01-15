<?php
namespace Applications\Backend\Modules\Cours;

class CoursController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'ADMika - Cours');
		$this->page->addVar('class_cours', 'active');
		
		$manC = $this->managers->getManagerOf('Cours');
		
		$listeCours = $manC->getList();
		
		$this->page->addVar('listeCours', $listeCours);
		$this->page->addVar('manM', $this->managers->getManagerOf('Matiere'));
		$this->page->updateVar("js" ,"<script>$('#checkAll').click(function () { var cases = $('#tabs').find('input[type=checkbox]'); $(cases).attr('checked', this.checked); $.uniform.update(cases); });</script>");
		
		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'un cours à la fois"});</script>');
				} else {
					$this->app->httpResponse()->redirect('/admin/cours/modifier-'.$check[0]);
				}
			} else {
				$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le modifier"});</script>');
			}
			
		// Cas d'ajout
		} else if ($request->postExists('ajouter')) {
			$this->app->httpResponse()->redirect('/admin/cours/ajouter');
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = $this->managers->getManagerOf('Cours')->getUnique($check[$i]);
				}
				//echo '<pre>';print_r($delete); echo '</pre>';
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteCours').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le supprimer"});</script>');
			}
		}
	}
	
	public function executeDelete(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) { 
			$this->managers->getManagerOf('Cours')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/admin/cours');
	}
	
	public function executeUpdate(\Library\HTTPRequest $request)
	{
		if($request->getExists('id')) {
			if(NULL != $this->managers->getManagerOf('Cours')->getUnique($request->getData('id'))) {
				$cours = $this->managers->getManagerOf('Cours')->getUnique($request->getData('id'));
				
				if($request->postExists('annuler')) {
					$this->app->httpResponse()->redirect('/admin/cours');
				}
				
				if($request->postExists('modifier')) {
					$cours = new \Library\Entities\Cours(array(
						'id' => $cours['id'],
						'matiere' => $request->postData('matiere'),
						'titre' => $request->postData('titre'),
						'description' => $request->postData('description'),
						'contenu' => $request->postData('contenu')
					));
			
					if($cours->isValid()) {
						$this->managers->getManagerOf('Cours')->save($cours);
						$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "<strong>Cours enregistré !</strong>"});</script>');
						$this->app->httpResponse()->redirect('/admin/cours');
					} else {
						$this->page->addVar('cours', $cours);
						$this->page->addVar('erreurs', $cours['erreurs']);
					}
				}
				
				$this->page->addVar('title', 'ADMika - Modifier '.$cours['titre']);
				$this->page->addVar('cours', $cours);
				$this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getCountOf($cours['id']));
				$this->page->addVar('manC', $this->managers->getManagerOf('Cours'));
				$this->page->addVar('matieres', $this->managers->getManagerOf('Matiere')->getList());
				
			} else {
			$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Aucun cours n\'a pour identifiant : '.$request->getData('id').'"});</script>');
			$this->app->httpResponse()->redirect('/admin/cours');
			}
		} 
	}
	
	public function executeAdd(\Library\HTTPRequest $request)
	{
		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/cours');
		}
		
		if($request->postExists('ajouter')) {
			$cours = new \Library\Entities\Cours(array(
				'auteur' => '42',
				'matiere' => $request->postData('matiere'),
				'titre' => $request->postData('titre'),
				'description' => $request->postData('description'),
				'contenu' => $request->postData('contenu')
			));
			
			if($cours->isValid()) {
				$this->managers->getManagerOf('Cours')->save($cours);
				$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "<strong>Cours enregistré !</strong>"});</script>');
				$this->app->httpResponse()->redirect('/admin/cours');
			} else {
				$this->page->addVar('cours', $cours);
				$this->page->addVar('erreurs', $cours['erreurs']);
			}
		}
		
		$this->page->addVar('title', 'ADMika - Ajouter un cours');
		$this->page->addVar('matieres', $this->managers->getManagerOf('Matiere')->getList());
	}
}
?>