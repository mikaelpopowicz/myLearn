<?php
namespace Applications\Admin\Modules\Param;

class ParamController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyAdmin - Paramètres');
		$this->page->addVar('class_param', 'active');
		//$this->app->config()->setVar("conf_date","01/01/2014");
		//$xml = $this->app->config()->save();
		//$this->page->addVar('xml', $xml[0]);
	}
	
	public function executeInfos(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyAdmin - Modification des informations générales');
		$this->page->addVar('class_param', 'active');
		
		if($request->postExists('annuler'))
		{
			$this->app->httpresponse()->redirect('/admin/parametres');
		}
		
		if($request->postExists('modifier')) {
			$infos = array(
				"nom" => $request->postData('nom'),
				"description" => $request->postData('description'),
				"email" => $request->postData('email'),
				"contact" => $request->postData('contact')
			);
			$erreur = array();
			foreach ($infos as $donnee => $value) {
				if(empty($value)) {
					$erreur[] = $donnee;
				}
			}
			if(empty($erreur)) {
				$this->app->config()->setVar('conf_nom',$infos['nom']);
				$this->app->config()->setVar('conf_description',$infos['description']);
				$this->app->config()->setVar('conf_email',$infos['email']);
				$this->app->config()->setVar('conf_contact',$infos['contact']);
				$this->app->config()->save();
				$this->app->httpresponse()->redirect('/admin/parametres');
			} else {
				$this->page->addVar('infos', $infos);
				$this->page->addVar('erreur', $erreur);
			}
		}
	}
	
	public function executeUser(\Library\HTTPRequest $request)
	{
		$user = $this->managers->getManagerOf('Administrateur')->getUnique($this->app->user()->getAttribute('id'));
		if($user != NULL)
		{
			if($request->postExists('annuler')) {
				$this->app->httpresponse()->redirect('/admin/parametres');
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

				
				
				if($user->isValid()) {
					$this->managers->getManagerOf('Administrateur')->save($user);
					$this->updateUserAttribute($user);
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "Informations modifiées"});</script>');
					$this->app->httpresponse()->redirect('/admin/parametres');
				} else {
					$this->page->addVar('profil', $user);
					$this->page->addVar('erreurs', $user['erreurs']);
				}

			}

			$this->page->addVar('title', 'MyAdmin - Modifier mes informations');
			$this->page->addVar('class_param', 'active');
			$this->page->addVar('profil', $user);
		}
	}
	
	public function executePassword(\Library\HTTPRequest $request)
	{
		$user = $this->managers->getManagerOf('Administrateur')->getUnique($this->app->user()->getAttribute('id'));
		if($user != NULL)
		{

			if($request->postExists('modifier')) {
				$erreurs = array();
				$pass1 = $request->postData('pass1');
				$pass2 = $request->postData('pass2');
				
				if($pass1 == $pass2)
				{
					$user->setPassword(sha1(md5(sha1(md5($user->salt())).sha1(md5($pass1)).sha1(md5($user->salt())))));
					$this->managers->getManagerOf('Administrateur')->save($user);
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "Informations modifiées"});</script>');
					$this->app->httpresponse()->redirect('/admin/parametres/');
				} else {
					$erreurs[] = 'Mot de passe non identique';
					$this->page->addVar('erreurs', $erreurs);
				}

			}

			$this->page->addVar('title', 'MyAdmin - Modifier mot de passe');
			$this->page->addVar('class_param', 'active');
			$this->page->addVar('profil', $user);
		}
	}
}
?>