<?php
namespace Applications\Admin\Modules\Matiere;

class MatiereController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Liste des matières');
		$this->page->addVar('class_cours', "active");
		$this->page->addVar('class_mat', "active");
		$this->page->addVar('listeMatiere', $this->managers->getManagerOf('Matiere')->getList());

		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous ne pouvez modifier qu\'une matière à la fois');
				} else {
					$this->app->httpResponse()->redirect('/admin/matieres/modifier-'.$check[0]);
				}
			} else {
				$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins une matière pour la modifier');
			}
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = $this->managers->getManagerOf('Matiere')->getUnique($check[$i]);
				}
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteMatiere').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins une matière pour la supprimer');
			}
		} else if ($request->postExists('volume')) {
			$this->managers->getManagerOf('Matiere')->addVolume();
			$this->app->httpResponse()->redirect('/admin/matieres');
		}
	}

	public function executeAjout(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Nouvelle matière');
		$this->page->addVar('class_cours', "active");
		$this->page->addVar('class_mat', "active");
		$this->page->addVar('fas',$this->getIcons());

		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/matieres');
		}
		
		if($request->postExists('ajouter')) {
			
			$matiere = new \Library\Entities\Matiere(array(
				"libelle" => $request->postData('libelle'),
				"uri" => \Library\Cleaner::getUri($request->postData('libelle')),
				"icon" => $request->postData('icon')
			));
			
			if($matiere->isValid()) {
				$this->managers->getManagerOf('Matiere')->save($matiere);
				$this->app->user()->setFlash('success','Création de la matière réussie');
				$this->app->httpresponse()->redirect('/admin/matieres');
			} else {
				$this->page->addVar('erreurs', $matiere['erreurs']);
				$this->page->addVar('matiere', $matiere);
			}
		}
	}

	public function executeModif(\Library\HTTPRequest $request)
	{
		$matiere = $this->managers->getManagerOf('Matiere')->getUnique($request->getData('id'));
		if($matiere != NULL) {
			$this->page->addVar('title', 'myAdmin - Modifier '.$matiere['libelle']);
			$this->page->addVar('class_cours', "active");
			$this->page->addVar('class_mat', "active");
			$this->page->addVar('fas',$this->getIcons());
			$this->page->addVar('matiere', $matiere);

			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/admin/matieres');
			}

			if($request->postExists('modifier')) {
			
			$mat = new \Library\Entities\Matiere(array(
				"id" => $matiere['id'],
				"libelle" => $request->postData('libelle'),
				"uri" => \Library\Cleaner::getUri($request->postData('libelle')),
				"icon" => $request->postData('icon')
			));
			
			if($mat->isValid()) {
				$this->managers->getManagerOf('Matiere')->save($mat);
				$this->app->user()->setFlash('success','Modification de la matière réussie');
				$this->app->httpresponse()->redirect('/admin/matieres');
			} else {
				$this->page->addVar('erreurs', $mat['erreurs']);
				$this->page->addVar('matiere', $mat);
			}
		}


		} else {
			$this->app->httpresponse()->redirect('/admin/matieres');
		}
	}

	public function executeDelete(\Library\HTTPRequest $request)
	{
		$erreurs = array();
		$success = array();
		for ($i=0; $i < $request->postData('count'); $i++) {
			$suppr = unserialize(base64_decode($request->postData('suppr_'.$i)));
			$cours = $suppr->cours();
			//echo '<pre>';print_r($cours);echo "</pre>";die();
			if($cours < 1) {
				$this->managers->getManagerOf('Matiere')->delete($suppr);
				$success[] = $suppr['libelle'];
			} else {
				$erreurs[$suppr['libelle']] = array(
					"cours" => $cours
				);
			}
		}
		if(empty($erreurs)) {
			$this->app->user()->setFlash('success','<strong>Suppression réussie !</strong>');
		} else {
			$str = "<br/>".count($success)." a(ont) été supprimée(s). Voici la liste des erreurs :<ul>";
			foreach ($erreurs as $key => $value) {
				$str .= "<li>".$key." - ";
				if($value['cours'] > 0) {
					$str .= $value['cours']." cours dépendant(s)";
				}
				$str .= "</li>";
			}
			$str .= "</ul>";
			if (count($erreurs) < $request->postData('count')) {
				$this->app->user()->setFlash('warning','<strong>Suppression partiellement réussie !</strong>'.$str);
			} else {
				$this->app->user()->setFlash('error','<strong>Suppression non réussie!</strong>'.$str);
			}
		}

		
		$this->app->httpResponse()->redirect('/admin/matieres');
	}

	public function getIcons()
	{
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$subject = file_get_contents('../Web/assets/css/font-awesome.css');
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

		$icons = array();
		foreach($matches as $match){
			$icons[] = $match[1];
		}
		return $icons;
	}
}