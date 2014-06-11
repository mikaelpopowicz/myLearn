<?php
namespace Applications\Admin\Modules\Param;

class ParamController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Paramètres');
		$this->page->addVar('class_param', 'active');
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
				"contact" => $request->postData('contact'),
				"address" => $request->postData('address'),
				"ville" => $request->postData('ville'),
				"cp" => $request->postData('cp'),
				"tel" => $request->postData('tel')
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
				$this->app->config()->setVar('conf_contact',$infos['contact']);
				$this->app->config()->setVar('conf_address',$infos['address']);
				$this->app->config()->setVar('conf_ville',$infos['ville']);
				$this->app->config()->setVar('conf_cp',$infos['cp']);
				$this->app->config()->setVar('conf_tel',$infos['tel']);
				$this->app->config()->save();
				$this->app->httpresponse()->redirect('/admin/parametres');
			} else {
				$this->page->addVar('infos', $infos);
				$this->page->addVar('erreur', $erreur);
			}
		}
	}
	
	public function executeSmtp(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Configuration STMP');
		$this->page->addVar('class_param', 'active');
		
		$smtp = array(
			"host" => $this->app->config()->get('smtp_host'),
			"port" => $this->app->config()->get('smtp_port'),
			"security" => $this->app->config()->get('smtp_security'),
			"user" => $this->app->config()->get('smtp_user'),
			"password" => $this->app->config()->get('smtp_pass'),
			"envoi" => $this->app->config()->get('conf_email')
		);
		
		if($request->postExists('annuler')) {
			$this->app->httpresponse()->redirect('/admin/parametres');
		}
		
		if($request->postExists('modifier')) {
			$smtp['host'] = $request->postData('host');
			$smtp['port'] = $request->postData('port');
			$smtp['security'] = $request->postData('security');
			$smtp['user'] = $request->postData('user');
			$smtp['password'] = $request->postData('password');
			$smtp['envoi'] = $request->postData('envoi');
			$erreur = array();
			foreach ($smtp as $donnee => $value) {
				if(empty($value)) {
					$erreur[] = $donnee;
				}
			}
			if(empty($erreur)) {
				$this->app->config()->setVar('smtp_host',$this->app->key()->encode($smtp['host'], base64_decode($this->app->config()->get('cryp_key')))['crypted']);
				$this->app->config()->setVar('smtp_port',$this->app->key()->encode($smtp['port'], base64_decode($this->app->config()->get('cryp_key')))['crypted']);
				$this->app->config()->setVar('smtp_user',$this->app->key()->encode($smtp['user'], base64_decode($this->app->config()->get('cryp_key')))['crypted']);
				$this->app->config()->setVar('smtp_pass',$this->app->key()->encode($smtp['password'], base64_decode($this->app->config()->get('cryp_key')))['crypted']);
				$this->app->config()->setVar('smtp_security',$this->app->key()->encode($smtp['security'], base64_decode($this->app->config()->get('cryp_key')))['crypted']);
				$this->app->config()->setVar('conf_email',$smtp['envoi']);
				$this->app->config()->save();
				$this->app->httpresponse()->redirect('/admin/parametres');
			} else {
				$this->page->addVar('smtp', $smtp);
				$this->page->addVar('erreur', $erreur);
			}
		}
		
		if($request->postExists('connexion'))
		{
			$sujet = 'Test de configuration STMP myLearn';
			$mail = 'Test de configuration SMTP de l\'établissement '.$this->app->config()->get('conf_nom').'<br/>';
			$this->app->mail()->setMail($this->app->config()->get('conf_contact'));
			$this->app->mail()->setMessage($sujet, $mail);
			$this->app->mail()->setSujet($sujet);
			$this->app->mail()->setHost($request->postData('host'));
			$this->app->mail()->setPort($request->postData('port'));
			$this->app->mail()->setSecurity($request->postData('security'));
			$this->app->mail()->setUsername($request->postData('user'));
			$this->app->mail()->setPassword($request->postData('password'));
			$this->app->mail()->setSender($request->postData('envoi'));
			$envoi = $this->app->mail()->send();
			if($envoi != 1)
			{
				$this->page->addVar('message', '<p class="text-center"><span class="text-danger">'.$envoi.'</span></p>');
			}
			else
			{
				$this->page->addVar('message', '<p class="text-center"><strong><span class="text-success">Connexion réussi</span></strong></p>');
			}
			
			$smtp['host'] = $request->postData('host');
			$smtp['port'] = $request->postData('port');
			$smtp['security'] = $request->postData('security');
			$smtp['user'] = $request->postData('user');
			$smtp['password'] = $request->postData('password');
			$smtp['envoi'] = $request->postData('envoi');
		}
		$this->page->addVar('smtp', $smtp);
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
					$this->app->user()->setFlash('success','Informations modifiées');
					$this->app->httpresponse()->redirect('/admin/parametres');
				} else {
					$this->page->addVar('profil', $user);
					$this->page->addVar('erreurs', $user['erreurs']);
				}

			}

			$this->page->addVar('title', 'myAdmin - Modifier mes informations');
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
					$this->app->user()->setFlash('success','Informations modifiées');
					$this->app->httpresponse()->redirect('/admin/parametres/');
				} else {
					$erreurs[] = 'Mot de passe non identique';
					$this->page->addVar('erreurs', $erreurs);
				}

			}

			$this->page->addVar('title', 'myAdmin - Modifier mot de passe');
			$this->page->addVar('class_param', 'active');
			$this->page->addVar('profil', $user);
		}
	}
}
?>