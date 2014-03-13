<?php
namespace Applications\Frontend\Modules\Membre;

class MembreController extends \Library\BackController
{

	public function executeIndex(\Library\HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated()) {

			if($request->postExists('modifier_profil')) {
				$this->app->httpresponse()->redirect('/membre/mon-profil/modifier-profil');
			}

			if($request->postExists('modifier_pass')) {
				$this->app->httpresponse()->redirect('/membre/mon-profil/modifier-mot-de-passe');
			}

			$this->page->addVar('title', 'Mika-p - Mon profil');
			$this->page->addVar('class_profil', 'active');
			$byte = $this->managers->getManagerOf('Byte')->getUnique($this->app->user()->getAttribute('id'));
			$this->page->addVar('profil', $byte);
		} else {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous devez être connecté pour accéder à cette page"});</script>');
			$this->app->httpresponse()->redirect('/');
		}
	}

	public function executeMesCours(\Library\HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated()) {

			$this->page->updateVar("js" ,"<script>$('#checkAll').click(function () { var cases = $('#tabs').find('input[type=checkbox]'); $(cases).attr('checked', this.checked); $.uniform.update(cases); });</script>");
			// Cas de modification
			if ($request->postExists('modifier')) {
				if ($request->postExists('check')) {
					$check = $request->postData('check');
					if (count($check) > 1) {
						$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'un cours à la fois"});</script>');
					} else {
						$this->app->httpResponse()->redirect('/cours/modifier-'.$check[0]);
					}
				} else {
					$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le modifier"});</script>');
				}
				
			// Cas d'ajout
			} else if ($request->postExists('ajouter')) {
				$this->app->httpResponse()->redirect('/cours/ecrire-un-cours');
				
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

			$this->page->addVar('title', 'Mika-p - Mes cours');
			$this->page->addVar('class_mes_cours', 'active');
			$byte = $this->managers->getManagerOf('Byte')->getUnique($this->app->user()->getAttribute('id'));
			$this->page->addVar('profil', $byte);
			$this->page->addVar('listeCours', $this->managers->getManagerOf('Cours')->getListByAuthor($this->app->user()->getAttribute('id')));
			$this->page->addVar('manC', $this->managers->getManagerOf('Comments'));
			$this->page->addVar('count', $this->managers->getManagerOf('Cours'));
		} else {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous devez être connecté pour accéder à cette page"});</script>');
			$this->app->httpresponse()->redirect('/');
		}
	}

	public function executeMaConfiguration(\Library\HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated()) {
			$this->page->addVar('title', 'Mika-p - Ma configuration');
			$this->page->addVar('class_config', 'active');
		} else {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous devez être connecté pour accéder à cette page"});</script>');
			$this->app->httpresponse()->redirect('/');
		}
	}

	public function executeModifierProfil(\Library\HTTPRequest $request) {
		if($this->app->user()->isAuthenticated()) {

			$byte = $this->managers->getManagerOf('Byte')->getUnique($this->app->user()->getAttribute('id'));

			if($request->postExists('annuler')) {
				$this->app->httpresponse()->redirect('/membre/mon-profil');
			}

			if($request->postExists('modifier')) {
				$mailList = $this->managers->getManagerOf('Byte')->getList();
				$mail = $request->postData('email');
				//echo "<pre>";print_r($mailList);echo "</pre>";
				foreach($mailList as $list) {
					if ($list['email'] == $mail && $list['email'] != $byte['email']) {
						$mail = "";
					}
				}



				$username = $this->managers->getManagerOf('Byte')->getByName($request->postData('username'));
				if($username != NULL) {
					//echo '<br><br><br><br><br><pre>';print_r($username);echo '</pre>';
					if($username['id'] == $byte['id']) {
						$name = $request->postData('username');
					} else {
						$name = "";
					}
				} else {
					$name = $request->postData('username');
				}

				$byte->setUsername($name);
				$byte->setNom($request->postData('nom'));
				$byte->setPrenom($request->postData('prenom'));
				$byte->setEmail($mail);

				$this->page->addVar('byte', $byte);
				
				if($byte->isValid()) {
					$this->managers->getManagerOf('Byte')->save($byte);
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "Profil modifié"});</script>');
					$this->app->httpresponse()->redirect('/membre/mon-profil');
				} else {
					$this->page->addVar('erreurs', $byte['erreurs']);
				}

			}

			$this->page->addVar('title', 'Mika-p - Modifier mon profil');
			$this->page->addVar('class_profil', 'active');
			$this->page->addVar('profil', $byte);
		} else {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous devez être connecté pour accéder à cette page"});</script>');
			$this->app->httpresponse()->redirect('/');
		}
	}

	public function executeModifierPass(\Library\HTTPRequest $request) {
		if($this->app->user()->isAuthenticated()) {

			$byte = $this->managers->getManagerOf('Byte')->getUnique($this->app->user()->getAttribute('id'));

			if($request->postExists('modifier')) {
				if($request->postExists('pass1') && $request->postExists('pass2')) {
					$pass1 = $request->postData('pass1');
					$pass2 = $request->postData('pass2');

					if($pass1 == $pass2) {
						$byte->setPassword(sha1(md5(sha1(md5($byte['salt'])).sha1(md5($request->postData('pass1'))).sha1(md5($byte['salt'])))));
						$byte->setToken($this->app->key()->getNewSalt(40));
						$this->managers->getManagerOf('Byte')->save($byte);
						$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "Mot de passe modifié"});</script>');
						$this->app->httpResponse()->redirect('/membre/mon-profil');
					} else {
						$this->page->addVar('erreurs', "");
					} 
				}
			}
			$this->page->addVar('title', 'Mika-p - Modifier mon mot de passe');
			$this->page->addVar('class_profil', 'active');
		}
	}
}
?>