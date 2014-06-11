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
				$user->setUsername($request->postData('username'));
				$user->setEmail($request->postData('email'));
				$user->setNom($request->postData('nom'));
				$user->setPrenom($request->postData('prenom'));

				if($user->isValid()) {
					$record = $this->managers->getManagerOf('Professeur')->save($user);
					if($record instanceof \Library\Entities\Error)
					{
						$this->app->user()->setFlash($record->type(),$record->message());
						if($record->code() == "OP_S")
						{
							$this->updateUserAttribute($user);
							$this->app->httpresponse()->redirect('/professeur/parametres');
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
					$user->setPassword($pass1);
					$record = $this->managers->getManagerOf('Professeur')->save($user);
					if($record instanceof \Library\Entities\Error)
					{
						$this->app->user()->setFlash($record->type(),$record->message());
						if($record->code() == "OP_S")
						{
							$this->app->httpresponse()->redirect('/professeur/parametres/');
						}
					}
				} else {
					$erreurs = 'Mot de passe non identique';
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
			// Cas de modification
			if ($request->postExists('modifier')) {
				if ($request->postExists('check')) {
					$check = $request->postData('check');
					if (count($check) > 1) {
						$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous ne pouvez modifier qu\'un cours à la fois');
					} else {
						$this->app->httpResponse()->redirect('/professeur/cours/modifier-'.$check[0]);
					}
				} else {
					$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins un cours pour le modifier');
				}
				
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
			$this->page->addVar('class_perso', 'active');
		
			$this->page->addVar('profil', $user);
		}
	}
}
?>