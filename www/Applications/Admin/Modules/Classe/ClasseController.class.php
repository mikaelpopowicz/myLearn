<?php
namespace Applications\Admin\Modules\Classe;

class ClasseController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myLearn - Liste des classes');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_cls', "active");
		$this->page->addVar('listeClasse', $this->managers->getManagerOf('Classe')->getList());
		$this->page->addVar('session', $this->managers->getManagerOf('Session'));
		$this->page->addVar('section', $this->managers->getManagerOf('Section'));

		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'une classe à la fois"});</script>');
				} else {
					$this->app->httpResponse()->redirect('/admin/classes/modifier-'.$check[0]);
				}
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,timeout: 10000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une classe pour la modifier"});</script>');
			}
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = $this->managers->getManagerOf('Classe')->getUnique($check[$i]);
				}
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteClasse').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une classe pour la supprimer"});</script>');
			}
		}
	}

	public function executeAjout(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myLearn - Nouvelle section');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_cls', "active");
		$this->page->addVar('sessions', $this->managers->getManagerOf('Session')->getList());
		$this->page->addVar('sections', $this->managers->getManagerOf('Section')->getList());

		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/classes');
		}
		
		if($request->postExists('ajouter')) {
			
			$classe = new \Library\Entities\Classe(array(
				"session" => $request->postData('session'),
				"section" => $request->postData('section'),
				"libelle" => $request->postData('libelle')
			));
			
			if($classe->isValid()) {
				$this->managers->getManagerOf('Classe')->save($classe);
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Création de la classe réussie"});</script>');
				$this->app->httpresponse()->redirect('/admin/classes');
			} else {
				$this->page->addVar('erreurs', $classe['erreurs']);
				$this->page->addVar('classe', $classe);
			}
		}
	}

	public function executeModif(\Library\HTTPRequest $request)
	{
		$classe = $this->managers->getManagerOf('Classe')->getUnique($request->getData('id'));
		if($classe != NULL) {
			$this->page->addVar('title', 'myLearn - Modifier '.$classe->session());
			$this->page->addVar('class_gest', "active");
			$this->page->addVar('class_cls', "active");
			$this->page->addVar('classe', $classe);
			$this->page->addVar('sessions', $this->managers->getManagerOf('Session')->getList());
			$this->page->addVar('sections', $this->managers->getManagerOf('Section')->getList());

			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/admin/classes');
			}

			if($request->postExists('modifier')) {
			
				$cls = new \Library\Entities\Classe(array(
					"id" => $classe['id'],
					"session" => $request->postData('session'),
					"section" => $request->postData('section'),
					"libelle" => $request->postData('libelle')
				));
				
				if($cls->isValid()) {
					$this->managers->getManagerOf('Classe')->save($cls);
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Modification de la classe réussie"});</script>');
					$this->app->httpresponse()->redirect('/admin/classes');
				} else {
					$this->page->addVar('erreurs', $cls['erreurs']);
					$this->page->addVar('classe', $cls);
				}
			}
		} else {
			$this->app->httpresponse()->redirect('/admin/classes');
		}
	}

	public function executeShow(\Library\HTTPRequest $request)
	{
		$session = $this->managers->getManagerOf('Session')->getUnique($request->getData('id'));
		if($session != NULL) {
			$this->page->addVar('title', 'myLearn - '.$session->session());
			$this->page->addVar('class_gest', "active");
			$this->page->addVar('class_sess', "active");
			$this->page->addVar('session', $session);

		} else {
			$this->app->httpresponse()->redirect('/admin/sessions');
		}
	}

	public function executeDelete(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) {
			$this->managers->getManagerOf('Classe')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/admin/classes');
	}
}