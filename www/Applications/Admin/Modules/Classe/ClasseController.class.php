<?php
namespace Applications\Admin\Modules\Classe;

class ClasseController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Liste des classes');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_cls', "active");
		$this->page->addVar('listeClasse', $this->managers->getManagerOf('Classe')->getList(0));
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
		$this->page->addVar('title', 'myAdmin - Nouvelle section');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_cls', "active");
		$this->page->addVar('sessions', $this->managers->getManagerOf('Session')->getList());
		$this->page->addVar('sections', $this->managers->getManagerOf('Section')->getList());

		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/classes');
		}
		
		if($request->postExists('ajouter')) {
			
			$classe = new \Library\Entities\Classe(array(
				"session" => unserialize(base64_decode($request->postData('session'))),
				"section" => unserialize(base64_decode($request->postData('section'))),
				"libelle" => $request->postData('libelle'),
				"uri" => \Library\Cleaner::getUri($request->postData('libelle'))
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
			$this->page->addVar('title', 'myAdmin - Modifier '.$classe->libelle());
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
					"session" => unserialize(base64_decode($request->postData('session'))),
					"section" => unserialize(base64_decode($request->postData('section'))),
					"libelle" => $request->postData('libelle'),
					"uri" => \Library\Cleaner::getUri($request->postData('libelle'))
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
		$classe = $this->managers->getManagerOf('Classe')->getUnique($request->getData('id'));
		if($classe != NULL) {
			$this->page->addVar('title', 'myAdmin - '.$classe->libelle());
			$this->page->addVar('class_gest', "active");
			$this->page->addVar('class_cls', "active");
			$this->page->addVar('classe', $classe);


			$this->page->addVar('allMatiere', $this->managers->getManagerOf('Matiere')->getListNone($classe->id()));
			$this->page->addVar('allProfesseur', $this->managers->getManagerOf('Professeur')->getListNone($classe->id()));
			$this->page->addVar('allEleve', $this->managers->getManagerOf('Eleve')->getListNone($classe->id()));
			$this->page->updateVar('includes',  __DIR__.'/Views/modal_add_eleve.php');
			$this->page->updateVar('includes',  __DIR__.'/Views/modal_add_matiere.php');
			$this->page->updateVar('includes',  __DIR__.'/Views/modal_add_professeur.php');
			
			// Cas d'ajout d'élève
			if($request->postExists('ajout_eleve')) {
				$sel_el = $request->postData('eleve');
				foreach ($sel_el as $key) {
					$etre = new \Library\Entities\Etre(array(
						"id" => $classe->id(),
						"eleve" => $key
					));
					$this->managers->getManagerOf('Etre')->add($etre);
				}
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Opération réussie"});</script>');
				$this->app->httpresponse()->redirect('/admin/classes/'.$classe->id());
				
			// Cas de suppression d'élève
			} else if ($request->postExists('supprimer_eleve')) {
				if ($request->postExists('check')) {
					$check = $request->postData('check');
					$delete = array();
					for ($i = 0; $i < count($check); $i++) {
						$eleve = unserialize(base64_decode($check[$i]));
						$delete[$i] = array(
							"etre" => new \Library\Entities\Etre(array(
								"id" => $classe->id(),
								"eleve" => $eleve->id()
							)),
							"eleve" => $eleve
						);
					}
					//print_r($delete);
					$this->page->addVar('delete', $delete);
					$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete_eleve.php');
					$this->page->updateVar('js', "<script>$('#modalDeleteEleve').modal('show');</script>");
				} else {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un élève pour le supprimer"});</script>');
				}
			// Cas d'ajout de professeur
			} else if ($request->postExists('ajout_professeur')) {
				$sel_prof = $request->postData('professeur');
				foreach ($sel_prof as $key) {
					$charger = new \Library\Entities\Charger(array(
						"id" => $classe->id(),
						"professeur" => $key
					));
					$this->managers->getManagerOf('Charger')->add($charger);
				}
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Opération réussie"});</script>');
				$this->app->httpresponse()->redirect('/admin/classes/'.$classe->id());
			// Cas de suppression de professeur
			} else if ($request->postExists('supprimer_professeur')) {
				if ($request->postExists('check')) {
					$check = $request->postData('check');
					$delete = array();
					for ($i = 0; $i < count($check); $i++) {
						$professeur = unserialize(base64_decode($check[$i]));
						$delete[$i] = array(
							"charger" => new \Library\Entities\Charger(array(
								"id" => $classe->id(),
								"professeur" => $professeur->id()
							)),
							"professeur" => $professeur
						);
					}
					$this->page->addVar('delete', $delete);
					$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete_professeur.php');
					$this->page->updateVar('js', "<script>$('#modalDeleteProfesseur').modal('show');</script>");
				} else {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un professeur pour le supprimer"});</script>');
				}
			// Cas d'ajout de matière
			} else if ($request->postExists('ajout_matiere')) {
				$sel_mat = $request->postData('matiere');
				foreach ($sel_mat as $key) {
					$assigner = new \Library\Entities\Assigner(array(
						"id" => $classe->id(),
						"matiere" => $key
					));
					$this->managers->getManagerOf('Assigner')->add($assigner);
				}
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Opération réussie"});</script>');
				$this->app->httpresponse()->redirect('/admin/classes/'.$classe->id());
			// Cas de suppression de matière
			} else if ($request->postExists('supprimer_matiere')) {
				if ($request->postExists('check')) {
					$check = $request->postData('check');
					$delete = array();
					for ($i = 0; $i < count($check); $i++) {
						$matiere = unserialize(base64_decode($check[$i]));
						$delete[$i] = array(
							"assigner" => new \Library\Entities\Assigner(array(
								"id" => $classe->id(),
								"matiere" => $matiere->id()
							)),
							"matiere" => $matiere
						);
					}
					$this->page->addVar('delete', $delete);
					$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete_matiere.php');
					$this->page->updateVar('js', "<script>$('#modalDeleteMatiere').modal('show');</script>");
				} else {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une matière pour la supprimer"});</script>');
				}
			}
		} else {
			$this->app->httpresponse()->redirect('/admin/classes');
		}
	}
	
	public function executeDelEleve(\Library\HTTPRequest $request)
	{
		if($request->postExists('del_eleve')) {
			for ($i=0; $i < $request->postData('count'); $i++) {
				$etre = unserialize(base64_decode($request->postData('suppr_'.$i)));
				$this->managers->getManagerOf('Etre')->delete($etre);
			}
			$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
			$this->app->httpResponse()->redirect('/admin/classes/'.$request->postData('classe'));
		} else {
			$this->app->httpResponse()->redirect('/admin/classes');
		}
	}
	
	public function executeDelProfesseur(\Library\HTTPRequest $request)
	{
		if($request->postExists('del_professeur')) {
			for ($i=0; $i < $request->postData('count'); $i++) {
				$charger = unserialize(base64_decode($request->postData('suppr_'.$i)));
				$this->managers->getManagerOf('Charger')->delete($charger);
			}
			$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
			$this->app->httpResponse()->redirect('/admin/classes/'.$request->postData('classe'));
		} else {
			$this->app->httpResponse()->redirect('/admin/classes');
		}
	}
	
	public function executeDelMatiere(\Library\HTTPRequest $request)
	{
		if($request->postExists('del_matiere')) {
			for ($i=0; $i < $request->postData('count'); $i++) {
				$this->managers->getManagerOf('Assigner')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
			}
			$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
			$this->app->httpResponse()->redirect('/admin/classes/'.$request->postData('classe'));
		} else {
			$this->app->httpResponse()->redirect('/admin/classes');
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