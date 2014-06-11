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
			// Cas de modification
			if ($request->postExists('modifier')) {
				if ($request->postExists('check')) {
					$check = $request->postData('check');
					if (count($check) > 1) {
						$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous ne pouvez modifier qu\'un cours à la fois');
					} else {
						$this->app->httpResponse()->redirect('/cours/modifier-'.$check[0]);
					}
				} else {
					$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le modifier');
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
					$this->page->addVar('delete', $delete);
					$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
					$this->page->updateVar('js', "<script>$('#modalDeleteCours').modal('show');</script>");
				} else {
					$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le supprimer');
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
				$date = $request->postData('anniversaire');
				if(!empty($date)) {
					$date = explode('/', $date);
					$date = $date[2].'-'.$date[1].'-'.$date[0];
					$date = new \DateTime($date);
				} else {
					$date = new \DateTime('0000-00-00');
				}

				$user->setUsername($request->postData('username'));
				$user->setNom($request->postData('nom'));
				$user->setPrenom($request->postData('prenom'));
				$user->setEmail($request->postData('email'));
				$user->setDateNaissance($date);

				if($user->isValid()) {
					$record = $this->managers->getManagerOf('Eleve')->save($user);
					if($record instanceof \Library\Entities\Error)
					{
						$this->app->user()->setFlash($record->type(),$record->message());
						if($record->code() == "OP_S")
						{
							$this->updateUserAttribute($user);
							$this->app->httpresponse()->redirect('/mon-compte');
						}
						else
						{
							$this->page->addVar('profil', $user);
							$this->page->addVar('erreurs', $user['erreurs']);
						}
					}
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
					$user->setPassword($pass1);
					$this->managers->getManagerOf('Eleve')->save($user);
					$this->app->user()->setFlash('success','Mot de passe modifié');
					$this->app->httpResponse()->redirect('/mon-compte');
				} else {
					$erreurs[] = 'Mot de passe non identique';
					$this->page->addVar('erreurs', $erreurs);
				} 
			}
		}
		$this->page->addVar('title', 'MyLearn - Modifier mon mot de passe');
		$this->page->addVar('class_profil', 'active');
	}
}
?>