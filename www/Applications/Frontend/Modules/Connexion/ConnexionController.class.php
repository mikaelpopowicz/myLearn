<?php
namespace Applications\Frontend\Modules\Connexion;
 
class ConnexionController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('no_layout', true);
		$this->page->addVar('title', 'myLearn - Connexion');
		$this->page->addVar('nom', $this->app->config()->get('conf_nom'));
		$this->page->addVar('desc', $this->app->config()->get('conf_description'));
		$this->page->addVar('mail', $this->app->config()->get('conf_email'));
		
	 	if($this->app->user()->isAuthenticated()) {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous êtes déjà connecté"});</script>');
	 		$this->app->httpResponse()->redirect('/');
	 	} else {
	 		if($request->postExists('go')) {
	 			$login = $request->postData('login');
				$pass = $request->postData('password');
				
				// Vérification du login
				$exists = $this->managers->getManagerOf('User')->getByName($login);
				
				// Si un utilisateur a ce login
				if($exists != NULL) {
					
					// On vérifie qu'il a le bon mot de passe
					$match = $this->managers->getManagerOf('User')->getByNamePass($login, sha1(md5(sha1(md5($exists['salt'])).sha1(md5($pass)).sha1(md5($exists['salt'])))));
					
					// Si cela nous retourne l'utilisateur
					if($match != NULL) {
						
						// Si le compte est activé
						if($match['active'] == 1) {
							$this->app->user()->setAuthenticated(true);
							$this->app->user()->setAttribute('username', $match['username']);
							$this->app->user()->setAttribute('id', $match['id']);
							
							if($this->managers->getManagerOf('Eleve')->getUnique($match['id']) != NULL) {
								$this->app->user()->setAttribute('status', 'Eleve');
							} else if($this->managers->getManagerOf('Administrateur')->getUnique($match['id']) != NULL) {
								$this->app->user()->setAttribute('status', 'Admin');
								$this->app->httpResponse()->redirect('/admin');
							} else if($this->managers->getManagerOf('Professeur')->getUnique($match['id']) != NULL) {
								$this->app->user()->setAttribute('status', 'Prof');
								$this->app->httpResponse()->redirect('/professeur');
							} else if($this->managers->getManagerOf('Gestionnaire')->getUnique($match['id']) != NULL) {
								$this->app->user()->setAttribute('status', 'Gestionnaire');
							}
							
							$this->app->httpResponse()->redirect('/');
							
						// Si le compte n'est pas activé
						} else {
							$this->page->addVar('erreurs', array('warning', 'Votre compte n\'est pas encore activé, cliquer <a href="/connexion/activer"><strong>ICI</strong></a> si vous n\'avez pas reçu le mail d\'activation'));
						}
					} else {
						$this->page->addVar('erreurs', array('danger', 'Vous avec commis une erreur sur votre identifiant/mot de passe'));
					}
				} else {
					$this->page->addVar('erreurs', array('danger', 'Vous avec commis une erreur sur votre identifiant/mot de passe'));
				}
	 		}
	 	}
	}
	
	public function executeLogout(\Library\HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated()) {
			$this->app->user()->delUser();
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "information", layout: "top", text: "Vous êtes déconnecté"});</script>');
			if($request->getExists('request')) {
				$this->app->httpResponse()->redirect($request->getData('request'));
			} else {
				$this->app->httpResponse()->redirect('/');
			}
		} else {
			$this->app->httpResponse()->redirect('/');
		}
	}
	
	public function executeSubscribe(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Mika-p - Inscription');
		
		if($request->postExists('go')) {
			
			$mailList = $this->managers->getManagerOf('Byte')->getList();
			//echo '<pre>';print_r($mailList);echo '</pre>';
			$mail = $request->postData('email');
			foreach($mailList as $list) {
				if ($list['email'] == $mail) {
					$mail = "";
				}
			}
			
			if($request->postData('pass1') == $request->postData('pass2')) {
				$pass = $request->postData('pass1');
			}
			$salt = $this->app->key()->getNewSalt();
			$name = $this->managers->getManagerOf('Byte')->getByName($request->postData('username')) != NULL ? "" : $request->postData('username');
			
			$user = new \Library\Entities\Byte(array(
				'username' => $name,
				'email' => $mail,
				'nom' => $request->postData('nom'),
				'password' => !empty($pass) ? sha1(md5(sha1(md5($salt)).sha1(md5($request->postData('pass1'))).sha1(md5($salt)))) : "",
				'salt' => $salt,
				'token' => $this->app->key()->getNewSalt(40)
			));
				
			if ($user->isValid())
			{
				//echo '<script>alert("Coucou");</script>';
				$this->managers->getManagerOf('Byte')->save($user);
				
				// Envoi du mail d'activation
				$message = '<h3>Bonjour, '.$user->username().'</h3>
							<p class="lead">Nous vous souhaitons la bienvenue sur Mika-p.fr</p>
							<p>Une fois votre compte activé vous pourrez participer activement au site, de la cr√©ation de cours jusqu\'au simple commentaire des autres. Nous déterminerons dans quelle(s) matière(s) vous aurez le droit créer des cours. Une fois fait, vous accéderez à la création de cours directement depuis la barre de naviguation du site lorsque vous serrez connecté.</p>
							<p class="callout">
								Pour activer votre compte  <a href="http://poo/connexion/'.$user->token().'"> cliquez ici!</a>
							</p>';
				$load = new \Library\Mailer($user->email(), "Activation de votre compte", $message, "noreply@mika-p.fr");
				
				$this->app->user()->setFlash('<script>noty({type: "success", layout: "top", text: "<strong>Opération réussie !</strong> Votre compte à bien été enregistré</br>Un email d\'activation vous a été envoyé, veuillez suivre les instructions afin d\'activer votre compte."});</script>');
				$this->app->httpResponse()->redirect('/connexion');
			}
			else
			{
				$this->page->addvar('byte', $user);
				$this->page->addVar('erreurs', $user->erreurs());
			}
		}
	}
	
	public function executeActivate(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Mika-p - Activation');
		$this->page->addVar('no_layout', true);
		$this->page->addVar('nom', $this->app->config()->get('conf_nom'));
		$this->page->addVar('desc', $this->app->config()->get('conf_description'));
		// Si le token est présent dans l'url
		if($request->getExists('token')) {
			
			// Récupération du manager et de l'utilisateur qui a ce token
			$manU = $this->managers->getManagerOf('User');
			$test = $manU->getByToken($request->getData('token'));
			
			// Si un utilisateur à bien ce token
			if($test != NULL) {
				
				// Si c'est un token d'activation
				if($test->active() == 0) {
					
					// On change l'état ACTIVE de cet utilisateur et lui donne un nouveau token
					$test->setActive(1);
					$test->setToken($this->app->key()->getNewSalt(40));
					$manU->save($test);
					$this->app->user()->setFlash('<script>noty({type: "success", layout: "top", text: "<strong>Activation réussie !</strong> Vous pouvez maintenant vous connecter"});</script>');
					$this->app->httpResponse()->redirect('/');
					
				// Sinon c'est token de restauration de mot de passe
				} else {
					$this->app->httpResponse()->redirect('/');
				}
				
			// Personne n'a ce token
			} else {
				$this->app->httpResponse()->redirect('/');
			}
			
		// Le token n'est pas présent dans l'url
		}
		
		// Si la demande d'envoi de lien d'activation a été faite
		if($request->postExists('go')) {
			// Récupération du manager et de l'utilisateur qui a ce token
			$manU = $this->managers->getManagerOf('User');
			$test = $manU->getByMail($request->postData('email'));
			
			// Si l'utilisateur existe
			if($test != NULL) {
				
				// Vérification que l'utilisateur n'est pas activé
				if($test->active() == 0) {
					// Envoi du mail d'activation
					$message = '<h3>Bonjour, '.$test->username().'</h3>
								<p class="lead">Nous vous souhaitons la bienvenue sur myLearn</p>
								<p>Une fois votre compte activé vous pourrez participer activement au site, de la création de cours jusqu\'au simple commentaire des autres. Nous déterminerons dans quelle(s) matière(s) vous aurez le droit créer des cours. Une fois fait, vous accéderez à la création de cours directement depuis la barre de naviguation du site lorsque vous serrez connecté.</p>
								<p class="callout">
									Pour activer votre compte  <a href="http://ppe/connexion/'.$test->token().'"> cliquez ici!</a>
								</p>';
					$sujet = 'Activation de votre compte';
					$this->app->mail()->setMail($test->email());
					$this->app->mail()->setMessage($sujet, $message);
					$this->app->mail()->setSujet($sujet);
					$this->app->mail()->send();
					$this->app->user()->setFlash('<script>noty({type: "success", layout: "topCenter", text: "<strong>Mail envoyé</strong>"});</script>');
					//echo "<pre>";print_r($this->app->mail()); echo "</pre>";
					//echo '<pre>';print_r($this->app->config()->get('conf_email'));echo '</pre>';
					$this->app->httpResponse()->redirect('/');
				} else {
					$this->app->user()->setFlash('<script>noty({type: "information", layout: "topCenter", text: "Votre compte est déjà activé"});</script>');
					$this->app->httpResponse()->redirect('/');
				}
			} else {
				$this->page->addVar('erreurs', array('danger', 'Aucun compte ne correspond à cet email'));
			}
		}
	}
	
	public function executePassReload(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Mika-p - Mot de passe perdu');
		$this->page->addVar('no_layout', true);
		$this->page->addVar('nom', $this->app->config()->get('conf_nom'));
		$this->page->addVar('desc', $this->app->config()->get('conf_description'));
		if($request->postExists('go')) {
			// Récupération du manager et de l'utilisateur qui a ce token
			$manU = $this->managers->getManagerOf('User');
			$test = $manU->getByMail($request->postData('email'));
			
			// Si l'utilisateur existe
			if($test != NULL) {
				
				// Vérification que l'utilisateur n'est pas activé
				if($test->active() == 1) {
					// Envoi du mail d'activation
					$message = '<h3>Bonjour, '.$test->username().'</h3>
								<p class="lead">Vous avez perdu votre mot de passe ?</p>
								<p>Pour réinitialiser veuillez simplement suivre le lien ci-dessous. <strong>Attention</strong>, si vous n\'avez pas fait cette demande veuillez ne pas la en prendre compte !</p>
								<p class="callout">
									Pour reinitialiser votre mot de passe  <a href="http://ppe/connexion/mot-de-passe-perdu/'.$test->token().'"> cliquez ici!</a>
								</p>';
					$sujet = "Réinitialisation du mot de passe";
					$this->app->mail()->setMail($test->email());
					$this->app->mail()->setMessage($sujet, $message);
					$this->app->mail()->setSujet($sujet);
					$this->app->mail()->send();
					$this->app->user()->setFlash('<script>noty({type: "information", layout: "topCenter", text: "<strong>Mail envoyé</strong>"});</script>');
					$this->app->httpResponse()->redirect('/connexion');
				} else {
					$this->page->addVar('erreurs', array('warning', 'Vous devez d\'abord <a href="/connexion/activer">activez</a> votre compte !'));
				}
			} else {
				$this->page->addVar('erreurs', array('danger', 'Aucun compte ne correspond à cet email'));
			}
		}	
	}
	
	public function executeNewPass(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Mika-p - Reinitialisation du mot de passe');
		$this->page->addVar('no_layout', true);
		$this->page->addVar('nom', $this->app->config()->get('conf_nom'));
		$this->page->addVar('desc', $this->app->config()->get('conf_description'));
		// Si le token est présent dans l'url
		if($request->getExists('token')) {
			
			// Récupération du manager et de l'utilisateur qui a ce token
			$manU = $this->managers->getManagerOf('User');
			$test = $manU->getByToken($request->getData('token'));
			
			// Si un utilisateur à bien ce token
			if($test != NULL) {
				$this->page->addVar('readonly', '');
				$this->page->addVar('disabled', '');
				
				// Si c'est un token de reinitialisation
				if($test->active() == 1) {
					
					// Si le nouveau mot de passe a été renseigné
					if($request->postExists('go')) {
						
						// Si les deux mots de passe ont été renseignés et identiques
						if($request->postExists('pass1') && $request->postExists('pass2')) {
							$pass1 = $request->postData('pass1');
							$pass2 = $request->postData('pass2');
							if($pass1 == $pass2 && !empty($pass1)) {
								
								$test->setPassword(sha1(md5(sha1(md5($test['salt'])).sha1(md5($pass1)).sha1(md5($test['salt'])))));
								$test->setToken($this->app->key()->getNewSalt(40));
								$manU->save($test);
								$this->app->user()->setFlash('<script>noty({type: "success", layout: "top", text: "<strong>Réinitialisation réussie !</strong> Vous pouvez maintenant vous connecter"});</script>');
								$this->app->httpResponse()->redirect('/connexion');
							} else {
								$this->page->addVar('erreurs', array('danger', 'Veuillez saisir deux mots de passe identiques'));
							}
						} 
					}
				} else {
					$this->app->httpResponse()->redirect('/connexion');
				}
	
			// Personne n'a ce token
			} else {
				$this->page->addVar('erreurs', array('danger', 'Erreur de token, veuillez vérifier le lien ou faites une nouvelle demande <a href="/connexion/mot-de-passe-perdu">ICI</a>'));
				$this->page->addVar('readonly', 'readonly');
				$this->page->addVar('disabled', 'disabled');
			}
		} else {
			$this->app->httpResponse()->redirect('/connexion');
		}
	}
}