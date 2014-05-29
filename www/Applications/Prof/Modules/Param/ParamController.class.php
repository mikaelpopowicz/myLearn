<?php
namespace Applications\Prof\Modules\Param;

class ParamController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Mes informations');
		$this->page->addVar('class_param', 'active');	
	}
	
	public function executeUser(\Library\HTTPRequest $request)
	{
		$user = $this->managers->getManagerOf('Professeur')->getUnique($this->app->user()->getAttribute('id'));
		if($user != NULL)
		{
			if($request->postExists('annuler')) {
				$this->app->httpresponse()->redirect('/professeur/parametres');
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
				//echo '<pre>';print_r($user);echo '</pre>';
				if($username != NULL) {
					if($username['id'] == $user['id']) {
						$name = $request->postData('username');
					} else {
						$name = "";
					}
				} else {
					$name = $request->postData('username');
				}

				$user->setUsername($name);
				$user->setEmail($mail);
				$user->setNom($request->postData('nom'));
				$user->setPrenom($request->postData('prenom'));

				
				
				if($user->isValid()) {
					$this->managers->getManagerOf('Professeur')->save($user);
					$this->updateUserAttribute($user);
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "Informations modifiées"});</script>');
					$this->app->httpresponse()->redirect('/professeur/parametres');
				} else {
					$this->page->addVar('profil', $user);
					$this->page->addVar('erreurs', $user['erreurs']);
				}

			}

			$this->page->addVar('title', 'MyLearn - Modifier mes informations');
			$this->page->addVar('class_param', 'active');
			$this->page->addVar('profil', $user);
		}
	}
	
	public function executePassword(\Library\HTTPRequest $request)
	{
		$user = $this->managers->getManagerOf('Professeur')->getUnique($this->app->user()->getAttribute('id'));
		if($user != NULL)
		{

			if($request->postExists('modifier')) {
				$erreurs = array();
				$pass1 = $request->postData('pass1');
				$pass2 = $request->postData('pass2');
				
				if($pass1 == $pass2)
				{
					$user->setPassword(sha1(md5(sha1(md5($user->salt())).sha1(md5($pass1)).sha1(md5($user->salt())))));
					$this->managers->getManagerOf('Professeur')->save($user);
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "Informations modifiées"});</script>');
					$this->app->httpresponse()->redirect('/professeur/parametres/');
				} else {
					$erreurs[] = 'Mot de passe non identique';
					$this->page->addVar('erreurs', $erreurs);
				}

			}

			$this->page->addVar('title', 'MyLearn - Modifier mot de passe');
			$this->page->addVar('class_param', 'active');
			$this->page->addVar('profil', $user);
		}
	}
	
	public function executeCours(\Library\HTTPRequest $request)
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
						$this->app->httpResponse()->redirect('/professeur/cours/modifier-'.$check[0]);
					}
				} else {
					$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le modifier"});</script>');
				}
				
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
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le supprimer"});</script>');
				}
			}
			$result = $this->managers->getManagerOf('Cours')->getListByAuthor($user->id());
			if(isset($result['cours']))
			{
				$this->page->addVar('listeCours', $result['cours']);
			}

			$this->page->addVar('title', 'MyLearn - Mes cours');
			$this->page->addVar('class_perso', 'active');
		
			$this->page->addVar('profil', $user);
		}
	}
}
?>