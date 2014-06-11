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
		$this->page->addVar('mail', $this->app->config()->get('conf_contact'));
		
	 	if($this->app->user()->isAuthenticated()) {
			$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "Vous êtes déjà connecté"});</script>');
	 		$this->app->httpResponse()->redirect('/');
	 	} else {
	 		if($request->postExists('go')) {
	 			$login = $request->postData('login');
				$pass = $request->postData('password');
				
				$user = $this->managers->getManagerOf('User')->connexion($login,$pass);

				if(isset($user['user']) && ($user['user'] instanceof \Library\Entities\User)) {
					$this->app->user()->setAuthenticated(true);
					$this->app->user()->setAttribute('username', $user['user']['username']);
					$this->app->user()->setAttribute('id', $user['user']['id']);
					$this->app->user()->setAttribute('nom', $user['user']['nom']);
					$this->app->user()->setAttribute('prenom', $user['user']['prenom']);
					$this->app->user()->setAttribute('email', $user['user']['email']);
					$this->app->user()->setAttribute('dateUser', base64_encode(serialize($user['user']['dateUser'])));
					$this->app->user()->setAttribute('status', $user['statut']);
					if(isset($user['classes']) && is_array($user['classes']))
					{
						$this->app->user()->setAttribute('classes', $user['classes']);
					}
					if(isset($user['matiere']))
					{
						$this->app->user()->setAttribute('matiere', $user['matiere']);
					}
					$this->app->httpResponse()->redirect('/');
				} else {
					$this->page->addVar('erreurs', array($user['Type'], $user['Message']));
					sleep(1);
				}
				
	 		}
	 	}
		
	}
	
	public function executeLogout(\Library\HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated()) {
			$this->app->user()->delUser();
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "information", layout: "topCenter", text: "Vous êtes déconnecté"});</script>');
		}
		$this->app->httpResponse()->redirect('/');
	}
	
	public function executeActivate(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Activation');
		$this->page->addVar('no_layout', true);
		$this->page->addVar('nom', $this->app->config()->get('conf_nom'));
		$this->page->addVar('desc', $this->app->config()->get('conf_description'));
		// Si le token est présent dans l'url
		if($request->getExists('token')) {
			$message = $this->managers->getManagerOf('User')->activation($request->getData('token'));
			$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "'.$message->type().'", layout: "topCenter", text: "'.$message->message().'"});</script>');
			$this->app->httpResponse()->redirect('/');
		}
		// Si la demande d'envoi de lien d'activation a été faite
		if($request->postExists('go')) {
			
			$result = $this->managers->getManagerOf('User')->activationRequest($request->postData('email'));
			$message = is_array($result) && isset($result['message']) ? $result['message'] : array("message"=>"","type"=>"");
			
			if (isset($result['mail']) && ($result['mail'] instanceof \Library\Entities\Crypt))
			{
				$crypt = $result['mail'];
				$mail = $this->app->key()->decode($crypt->message(), $crypt->cle());
				$sujet = 'Activation de votre compte';
				$this->app->mail()->setMail($request->postData('email'));
				$this->app->mail()->setMessage($sujet, $mail);
				$this->app->mail()->setSujet($sujet);
				$envoi = $this->app->mail()->send();
				if($envoi != 1)
				{
					$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "error", layout: "topCenter", text: "'.$envoi.'"});</script>');
				}
				else
				{
					$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "'.$message->type().'", layout: "topCenter", text: "'.$message->message().'"});</script>');
				}
				$this->app->httpResponse()->redirect('/');
			}
			else if($message->code() == "ACT_WM")
			{
				$this->page->addVar('erreurs', array($message->type(), $message->message()));
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "'.$message->type().'", layout: "topCenter", text: "'.$message->message().'"});</script>');
				$this->app->httpResponse()->redirect('/');
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
					$message = '<h3>Bonjour, '.$test->nom().' '.$test->prenom().'</h3>
								<p class="lead">Vous avez perdu votre mot de passe ?</p>
								<p>Pour réinitialiser veuillez simplement suivre le lien ci-dessous. <strong>Attention</strong>, si vous n\'avez pas fait cette demande veuillez ne pas la en prendre compte !</p>
								<p class="callout">
									Pour reinitialiser votre mot de passe  <a href="http://'.$_SERVER['HTTP_HOST'].'/connexion/mot-de-passe-perdu/'.$test->token().'"> cliquez ici!</a>
								</p>';
					$sujet = "Réinitialisation du mot de passe";
					$this->app->mail()->setMail($test->email());
					$this->app->mail()->setMessage($sujet, $message);
					$this->app->mail()->setSujet($sujet);
					$this->app->mail()->send();
					$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "information", layout: "topCenter", text: "<strong>Mail envoyé</strong>"});</script>');
					//echo "<pre>";print_r($this->app->mail()); echo "</pre>";
					//echo $this->app->mail()->headers();
					$this->app->httpResponse()->redirect('/');
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
								$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "success", layout: "top", text: "<strong>Réinitialisation réussie !</strong> Vous pouvez maintenant vous connecter"});</script>');
								$this->app->httpResponse()->redirect('/connexion');
							} else {
								$this->page->addVar('erreurs', array('danger', 'Veuillez saisir deux mots de passe identiques'));
							}
						} 
					}
				} else {
					$this->app->httpResponse()->redirect('/');
				}
	
			// Personne n'a ce token
			} else {
				$this->page->addVar('erreurs', array('danger', 'Erreur de token, veuillez vérifier le lien ou faites une nouvelle demande <a href="/connexion/mot-de-passe-perdu">ICI</a>'));
				$this->page->addVar('readonly', 'readonly');
				$this->page->addVar('disabled', 'disabled');
			}
		} else {
			$this->app->httpResponse()->redirect('/');
		}
	}
}