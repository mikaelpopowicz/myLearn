<?php
namespace Applications\Frontend\Modules\Membre;

class MembreController extends \Library\BackController
{

	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Mon compte');
		$this->page->addVar('class_profil', 'active');
		$user = $this->managers->getManagerOf('Eleve')->getUnique($this->app->user()->getAttribute('id'));
		$naissance = "";
		if($user != NULL)
		{
			if($user->dateNaissance() instanceof \DateTime)
			{
				$naissance = $user->dateNaissance()->format('d/m/Y');
			}
		}
		$this->page->addVar('naissance', $naissance);
	}

	public function executeMesCours(\Library\HTTPRequest $request)
	{
		$user = $this->managers->getManagerOf('User')->getUnique($this->app->user()->getAttribute('id'));
		if($user != NULL)
		{
			$this->page->updateVar("js" ,"<script>$('#checkAll').click(function () { var cases = $('#tabs').find('input[type=checkbox]'); $(cases).attr('checked', this.checked);});</script>");
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
						$delete[$i] = $this->managers->getManagerOf('Cours')->getUnique($check[$i])['cours'];
					}
					$this->page->addVar('delete', $delete);
					$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
					$this->page->updateVar('js', "<script>$('#modalDeleteCours').modal('show');</script>");
				} else {
					$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le supprimer"});</script>');
				}
			}
			$result = $this->managers->getManagerOf('Cours')->getListByAuthor($user->id());
			if(isset($result['cours']))
			{
				$this->page->addVar('listeCours', $result['cours']);
			}

			$this->page->addVar('title', 'MyLearn - Mes cours');
			$this->page->addVar('class_mes_cours', 'active');
		
			$this->page->addVar('profil', $user);
			$this->page->addVar('key', $this->app->key());
		}
		
	}

	public function executeMaConfiguration(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Ma configuration');
		$this->page->addVar('class_config', 'active');
	}

	public function executeModifierProfil(\Library\HTTPRequest $request)
	{
		$user = $this->managers->getManagerOf('Eleve')->getUnique($this->app->user()->getAttribute('id'));
		if($user != NULL)
		{
			if($request->postExists('annuler')) {
				$this->app->httpresponse()->redirect('/mon-compte');
			}

			if($request->postExists('modifier')) {
				$mailList = $this->managers->getManagerOf('User')->getList();
				$mail = $request->postData('email');
				foreach($mailList as $list) {
					if ($list['email'] == $mail && $list['email'] != $user['email']) {
						$mail = "";
					}
				}

				$username = $this->managers->getManagerOf('User')->getByName($request->postData('username'));
				if($username != NULL) {
					if($username['id'] == $user['id']) {
						$name = $request->postData('username');
					} else {
						$name = "";
					}
				} else {
					$name = $request->postData('username');
				}
				
				$date = $request->postData('anniversaire');
				if(!empty($date)) {
					$date = explode('/', $date);
					$date = $date[2].'-'.$date[1].'-'.$date[0];
					$date = new \DateTime($date);
				} else {
					$date = new \DateTime('0000-00-00');
				}

				$user->setUsername($name);
				$user->setNom($request->postData('nom'));
				$user->setPrenom($request->postData('prenom'));
				$user->setEmail($mail);
				$user->setDateNaissance($date);

				
				
				if($user->isValid()) {
					$this->managers->getManagerOf('Eleve')->save($user);
					$this->updateUserAttribute($user);
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "Informations modifiées"});</script>');
					$this->app->httpresponse()->redirect('/mon-compte');
				} else {
					$this->page->addVar('profil', $user);
					$this->page->addVar('erreurs', $user['erreurs']);
				}

			}

			$this->page->addVar('title', 'MyLearn - Modifier mes informations');
			$this->page->addVar('class_profil', 'active');
			$this->page->addVar('profil', $user);
		}
	}

	public function executeModifierPass(\Library\HTTPRequest $request)
	{
		$user = $this->managers->getManagerOf('Eleve')->getUnique($this->app->user()->getAttribute('id'));

		if($request->postExists('modifier')) {
			if($request->postExists('pass1') && $request->postExists('pass2')) {
				$pass1 = $request->postData('pass1');
				$pass2 = $request->postData('pass2');

				if($pass1 == $pass2) {
					$user->setPassword(sha1(md5(sha1(md5($user['salt'])).sha1(md5($request->postData('pass1'))).sha1(md5($user['salt'])))));
					$user->setToken($this->app->key()->getNewSalt(40));
					$this->managers->getManagerOf('Eleve')->save($user);
					$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "Mot de passe modifié"});</script>');
					$this->app->httpResponse()->redirect('/mon-compte');
				} else {
					$this->page->addVar('erreurs', "");
				} 
			}
		}
		$this->page->addVar('title', 'MyLearn - Modifier mon mot de passe');
		$this->page->addVar('class_profil', 'active');
	}
}
?>