<?php
namespace Applications\Admin\Modules\Professeur;

class ProfesseurController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Liste des professeurs');
		$this->page->addVar('class_user', "active");
		$this->page->addVar('class_prof', "active");
		$this->page->addVar('listeProfesseur', $this->managers->getManagerOf('Professeur')->getList());
		$this->page->addVar('matiere', $this->managers->getManagerOf('Matiere'));
		$test = "Truc de fou, j'aime très fort ma doudou, elle est trop belle !";
		$test_cr = $this->app->key()->encode($test);
		$test_de = $this->app->key()->decode($test_cr['crypted'], $test_cr['key']);

		$this->page->addVar('test', $test);
		$this->page->addVar('test_cr', $test_cr);
		$this->page->addVar('test_de', $test_de);

		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'un professeur à la fois"});</script>');
				} else {
					$this->app->httpResponse()->redirect('/admin/professeurs/modifier-'.$check[0]);
				}
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,timeout: 10000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un professeur pour le modifier"});</script>');
			}
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = $this->managers->getManagerOf('Professeur')->getUnique($check[$i]);
				}
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteProf').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "warning", layout: "top", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un professeur pour le supprimer"});</script>');
			}
		}
	}

	public function executeAjout(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myAdmin - Nouveau professeur');
		$this->page->addVar('class_user', "active");
		$this->page->addVar('class_prof', "active");
		$this->page->addVar('listeMatiere', $this->managers->getManagerOf('Matiere')->getList());

		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/admin/professeurs');
		}
		
		if($request->postExists('ajouter')) {
			$mdp = $this->app->key()->getNewSalt(8);
			$salt = $this->app->key()->getNewSalt(40);
			
			$professeur = new \Library\Entities\Professeur(array(
				"username" => $request->postData('username'),
				"nom" => $request->postData('nom'),
				"prenom" => $request->postData('prenom'),
				"email" => $request->postData('email'),
				"salt" => $salt,
				"password" => sha1(md5(sha1(md5($salt)).sha1(md5($mdp)).sha1(md5($salt)))),
				"token" => $this->app->key()->getNewSalt(40),
				"matiere" => $request->postData('matiere')
			));
			
			if($professeur->isValid()) {
				$this->managers->getManagerOf('Professeur')->save($professeur);
				$message = '<h3>Bonjour, '.$professeur->nom().' '.$professeur->prenom().'</h3>
								<p class="lead">Nous vous souhaitons la bienvenue sur myLearn</p>
								<p>Votre compte a été créé, vous pouvez maintenant activer votre compte en suivant le lien ci-dessous, pour pourrez vous connecter avec les identifiants suivants :
								<ul><li><strong>Username :</strong> '.$professeur->username().'</li>
								<li><strong>Mot de passe :</strong> '.$mdp.'</li></ul>
								</p>
								<p class="callout">
									Pour activer votre compte  <a href="http://'.$_SERVER['HTTP_HOST'].'/connexion/'.$professeur->token().'"> cliquez ici!</a>
								</p>';
				$sujet = 'Activation de votre compte';
				$this->app->mail()->setMail($professeur->email());
				$this->app->mail()->setMessage($sujet, $message);
				$this->app->mail()->setSujet($sujet);
				$this->app->mail()->send();
				$token = $this->managers->getManagerOf('Professeur')->getLast($professeur)['token'];
				$encoded = $this->app->key()->encode($message);
				$crypt = new \Library\Entities\Crypt(array(
					"id" => $token,
					"message" => $encoded['crypted'],
					"cle" => $encoded['key']
					));
				$this->managers->getManagerOf('Crypt')->add($crypt);
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Enregistrement du professeur réussi"});</script>');
				$this->app->httpresponse()->redirect('/admin/professeurs');
			} else {
				$this->page->addVar('erreurs', $professeur['erreurs']);
				$this->page->addVar('professeur', $professeur);
			}
		}
	}

	public function executeModif(\Library\HTTPRequest $request)
	{
		$matiere = $this->managers->getManagerOf('Matiere')->getUnique($request->getData('id'));
		if($matiere != NULL) {
			$this->page->addVar('title', 'myAdmin - Modifier '.$matiere['libelle']);
			$this->page->addVar('class_cours', "active");
			$this->page->addVar('class_mat', "active");
			$this->page->addVar('fas',$this->getIcons());
			$this->page->addVar('matiere', $matiere);

			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/admin/matieres');
			}

			if($request->postExists('modifier')) {
			
			$mat = new \Library\Entities\Matiere(array(
				"id" => $matiere['id'],
				"libelle" => $request->postData('libelle'),
				"icon" => $request->postData('icon')
			));
			
			if($mat->isValid()) {
				$this->managers->getManagerOf('Matiere')->save($mat);
				$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "Création de la matière réussie"});</script>');
				$this->app->httpresponse()->redirect('/admin/matieres');
			} else {
				$this->page->addVar('erreurs', $mat['erreurs']);
				$this->page->addVar('matiere', $mat);
			}
		}


		} else {
			$this->app->httpresponse()->redirect('/admin/matieres');
		}
	}

	public function executeDelete(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) {
			$suppr = unserialize(base64_decode($request->postData('suppr_'.$i)));
				$this->managers->getManagerOf('Professeur')->delete($suppr);
			}
		$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/admin/professeurs');
	}
}
?>