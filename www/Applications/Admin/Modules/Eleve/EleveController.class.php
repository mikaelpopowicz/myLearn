<?php
namespace Applications\Admin\Modules\Eleve;

class EleveController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Liste des élèves');
		$this->page->addVar('class_user', "active");
		$this->page->addVar('class_eleve', "active");
		$this->page->addVar('listeEleve', $this->managers->getManagerOf('Eleve')->getList());
		$this->page->addVar('matiere', $this->managers->getManagerOf('Matiere'));
		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'un élève à la fois"});</script>');
				} else {
					$this->app->httpResponse()->redirect('/admin/eleves/modifier-'.$check[0]);
				}
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,timeout: 10000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un élève pour le modifier"});</script>');
			}
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = $this->managers->getManagerOf('Eleve')->getUnique($check[$i]);
				}
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteEleve').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un élève pour le supprimer"});</script>');
			}
		}
	}

	public function executeAjout(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Nouvel élève');
		$this->page->addVar('class_user', "active");
		$this->page->addVar('class_eleve', "active");

		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/eleves');
		}
		
		if($request->postExists('ajouter')) {
			$mdp = $this->app->key()->getNewSalt(8);
			$salt = $this->app->key()->getNewSalt(40);
			$date = $request->postData('date');
			if(!empty($date)) {
				$date = explode('/', $date);
				$date = $date[2].'-'.$date[1].'-'.$date[0];
				$date = new \DateTime($date);
			} else {
				$date = new \DateTime('0000-00-00');
			}
			
			$username = strtolower(substr($request->postData('prenom'),0,1).$request->postData('nom'));
			
			$eleve = new \Library\Entities\Eleve(array(
				"username" => $username,
				"nom" => $request->postData('nom'),
				"prenom" => $request->postData('prenom'),
				"email" => $request->postData('email'),
				"dateNaissance" => $date,
				"salt" => $salt,
				"password" => sha1(md5(sha1(md5($salt)).sha1(md5($mdp)).sha1(md5($salt)))),
				"token" => $this->app->key()->getNewSalt(40)
			));
			
			if($eleve->isValid()) {
				$record = $this->managers->getManagerOf('Eleve')->save($eleve);
				$http = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
				if($record == false)
				{
					$message = '<h3>Bonjour, '.$eleve->nom().' '.$eleve->prenom().'</h3>
									<p class="lead">Nous vous souhaitons la bienvenue sur myLearn</p>
									<p>Votre compte a été créé, vous pouvez maintenant activer votre compte en suivant le lien ci-dessous, pour pourrez vous connecter avec les identifiants suivants :
									<ul><li><strong>Username :</strong> '.$eleve->username().'</li>
									<li><strong>Mot de passe :</strong> '.$mdp.'</li></ul>
									</p>
									<p class="callout">
										Pour activer votre compte  <a href="'.$http.'://'.$_SERVER['HTTP_HOST'].'/connexion/'.$eleve->token().'"> cliquez ici!</a>
									</p>';
				
					$encoded = $this->app->key()->encode($message);
					$crypt = new \Library\Entities\Crypt(array(
						"id" => $eleve->token(),
						"message" => $encoded['crypted'],
						"cle" => $encoded['key']
					));
					$this->managers->getManagerOf('Crypt')->add($crypt);				
				
					$sujet = 'Activation de votre compte';
					$this->app->mail()->setMail($eleve->email());
					$this->app->mail()->setMessage($sujet, $message);
					$this->app->mail()->setSujet($sujet);
				
				
					$envoi = $this->app->mail()->send();
					if($envoi == 1)
					{
						$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Enregistrement de l\'élève réussi"});</script>');
					}
					else
					{
						$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "error", layout: "topCenter", text: "'.$envoi.'"});</script>');
					}
					
					$this->app->httpresponse()->redirect('/admin/eleves');
				}
				else
				{
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "'.$record->type().'", layout: "topCenter", text: "'.$record->message().'"});</script>');
					$this->page->addVar('$eleve', $eleve);
				}
				
				
				
			} else {
				$this->page->addVar('erreurs', $eleve['erreurs']);
				$this->page->addVar('eleve', $eleve);
			}
		}
	}

	public function executeModif(\Library\HTTPRequest $request)
	{
		$eleve = $this->managers->getManagerOf('Eleve')->getUnique($request->getData('id'));
		if($eleve != NULL) {
			$this->page->addVar('title', 'myAdmin - Modifier '.$eleve['nom']);
			$this->page->addVar('class_user', "active");
			$this->page->addVar('class_eleve', "active");
			$this->page->addVar('eleve', $eleve);
			if($eleve->dateNaissance() != "0000-00-00") {
				$dateN = $eleve->dateNaissance()->format('d/m/Y');
			} else {
				$dateN = "";
			}
			$this->page->addVar('date', $dateN);

			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/admin/eleves');
			}
			
			if($request->postExists('modifier')) {
				$date = $request->postData('date');
				if(!empty($date)) {
					$date = explode('/', $date);
					$date = $date[2].'-'.$date[1].'-'.$date[0];
					$date = new \DateTime($date);
				} else {
					$date = new \DateTime('0000-00-00');
				}
			
				$el = new \Library\Entities\Eleve(array(
					"id" => $eleve['id'],
					"username" => strtolower($request->postData('username')),
					"nom" => $request->postData('nom'),
					"prenom" => $request->postData('prenom'),
					"email" => $request->postData('email'),
					"password" => $eleve['password'],
					"salt" => $eleve['salt'],
					"token" => $eleve['token'],
					"active" => $eleve['active'],
					"dateNaissance" => $date
				));
			
				if($el->isValid()) {
					$this->managers->getManagerOf('Eleve')->save($el);
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Modification réussie"});</script>');
					$this->app->httpresponse()->redirect('/admin/eleves');
				} else {
					$this->page->addVar('erreurs', $el['erreurs']);
					$this->page->addVar('eleve', $el);
				}
			}
		} else {
			$this->app->httpresponse()->redirect('/admin/eleves');
		}
	}

	public function executeDelete(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) {
			$suppr = unserialize(base64_decode($request->postData('suppr_'.$i)));
				$this->managers->getManagerOf('Eleve')->delete($suppr);
			}
		$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/admin/eleves');
	}
}
?>