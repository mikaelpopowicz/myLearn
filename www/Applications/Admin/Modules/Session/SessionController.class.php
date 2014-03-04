<?php
namespace Applications\Admin\Modules\Session;

class SessionController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myLearn - Liste des sessions');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_sess', "active");
		$this->page->addVar('listeSession', $this->managers->getManagerOf('Session')->getList());
		$this->page->addVar('control', $this->managers->getManagerOf('Session'));

		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'une session à la fois"});</script>');
				} else {
					$this->app->httpResponse()->redirect('/admin/sessions/modifier-'.$check[0]);
				}
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,timeout: 10000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une session pour la modifier"});</script>');
			}
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = $this->managers->getManagerOf('Session')->getUnique($check[$i]);
				}
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteSession').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une session pour la supprimer"});</script>');
			}
		}
	}

	public function executeAjout(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myLearn - Nouvelle section');
		$this->page->addVar('class_gest', "active");
		$this->page->addVar('class_sess', "active");

		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/sessions');
		}
		
		if($request->postExists('ajouter')) {
			
			$session = new \Library\Entities\Session(array(
				"session" => $request->postData('session')
			));
			
			if($session->isValid()) {
				$this->managers->getManagerOf('Session')->save($session);
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Création de la session réussie"});</script>');
				$this->app->httpresponse()->redirect('/admin/sessions');
			} else {
				$this->page->addVar('erreurs', $session['erreurs']);
				$this->page->addVar('session', $session);
			}
		}
	}

	public function executeModif(\Library\HTTPRequest $request)
	{
		$session = $this->managers->getManagerOf('Session')->getUnique($request->getData('id'));
		if($session != NULL) {
			$this->page->addVar('title', 'myLearn - Modifier '.$session->session());
			$this->page->addVar('class_gest', "active");
			$this->page->addVar('class_sess', "active");
			$this->page->addVar('session', $session);

			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/admin/sessions');
			}

			if($request->postExists('modifier')) {
			
				$sess = new \Library\Entities\Session(array(
					"id" => $session['id'],
					"session" => $request->postData('session')
				));
				
				if($sess->isValid()) {
					$this->managers->getManagerOf('Session')->save($sess);
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Modification de la section réussie"});</script>');
					$this->app->httpresponse()->redirect('/admin/sessions');
				} else {
					$this->page->addVar('erreurs', $sess['erreurs']);
					$this->page->addVar('session', $sess);
				}
			}
		} else {
			$this->app->httpresponse()->redirect('/admin/sessions');
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
			$this->managers->getManagerOf('Session')->delete(unserialize(base64_decode($request->postData('suppr_'.$i))));
		}
		$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/admin/sessions');
	}
}