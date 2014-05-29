<?php
namespace Applications\Admin\Modules\Section;

class SectionController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Liste des sections');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_sec', "active");
		$this->page->addVar('listeSection', $this->managers->getManagerOf('Section')->getList());

		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'une section à la fois"});</script>');
				} else {
					$this->app->httpResponse()->redirect('/admin/sections/modifier-'.$check[0]);
				}
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,timeout: 10000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une section pour la modifier"});</script>');
			}
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = $this->managers->getManagerOf('Section')->getUnique($check[$i]);
				}
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteSection').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une section pour la supprimer"});</script>');
			}
		}
	}

	public function executeAjout(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Nouvelle section');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_sec', "active");

		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/sections');
		}
		
		if($request->postExists('ajouter')) {
			
			$section = new \Library\Entities\Section(array(
				"libelle" => $request->postData('libelle'),
				"admin" => $this->app->user()->getAttribute('id')
			));
			
			if($section->isValid()) {
				$this->managers->getManagerOf('Section')->save($section);
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Création de la section réussie"});</script>');
				$this->app->httpresponse()->redirect('/admin/sections');
			} else {
				$this->page->addVar('erreurs', $section['erreurs']);
				$this->page->addVar('section', $section);
			}
		}
	}

	public function executeModif(\Library\HTTPRequest $request)
	{
		$section = $this->managers->getManagerOf('Section')->getUnique($request->getData('id'));
		if($section != NULL) {
			$this->page->addVar('title', 'myAdmin - Modifier '.$section['libelle']);
			$this->page->addVar('class_gest', "active");
			$this->page->addVar('class_sec', "active");
			$this->page->addVar('section', $section);

			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/admin/sections');
			}

			if($request->postExists('modifier')) {
			
				$sec = new \Library\Entities\Section(array(
					"id" => $section['id'],
					"libelle" => $request->postData('libelle'),
					"admin" => $section['admin']
				));
				
				if($sec->isValid()) {
					$this->managers->getManagerOf('Section')->save($sec);
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Modification de la section réussie"});</script>');
					$this->app->httpresponse()->redirect('/admin/sections');
				} else {
					$this->page->addVar('erreurs', $sec['erreurs']);
					$this->page->addVar('section', $sec);
				}
			}
		} else {
			$this->app->httpresponse()->redirect('/admin/sections');
		}
	}

	public function executeDelete(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) {
			$this->managers->getManagerOf('Section')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/admin/sections');
	}
}