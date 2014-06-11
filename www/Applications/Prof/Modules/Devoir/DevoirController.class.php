<?php
namespace Applications\Prof\Modules\Devoir;

class DevoirController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Devoirs');
		$this->page->addVar('class_devoir', 'active');
		$devoirs = $this->managers->getManagerOf('Devoir')->getList($this->app->user()->getAttribute('id'),true);
		$this->page->addVar('devoirs', $devoirs);
		
		// Cas de modification
		if ($request->postExists('modifier')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				if (count($check) > 1) {
					$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous ne pouvez modifier qu\'un devoir à la fois');
				} else {
					$this->app->httpResponse()->redirect('/professeur/devoirs/modifier-'.unserialize(base64_decode($check[0]))->id());
				}
			} else {
				$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins un devoir pour le modifier');
			}
			
		// Cas de suppression
		} else if ($request->postExists('supprimer')) {
			if ($request->postExists('check')) {
				$check = $request->postData('check');
				$delete = array();
				for ($i = 0; $i < count($check); $i++) {
					$delete[$i] = unserialize(base64_decode($check[$i]));
				}
				$this->page->addVar('delete', $delete);
				$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete.php');
				$this->page->updateVar('js', "<script>$('#modalDeleteDevoir').modal('show');</script>");
			} else {
				$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins un devoir pour le supprimer');
			}
		}
	}
	
	public function executeAjouter(\Library\HTTPRequest $request)
	{
		
		if($request->postExists('annuler')) {
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
		
		if($request->postExists('ajouter')) {
			
			$date = $request->postData('date');
			if(!empty($date)) {
				$date = explode('/', $date);
				$date = $date[2].'-'.$date[1].'-'.$date[0];
				$date = new \DateTime($date);
			} else {
				$date = new \DateTime('0000-00-00');
			}
			
			$user = $this->managers->getManagerOf('User')->getUnique($this->app->user()->getAttribute('id'));
			$devoir = new \Library\Entities\Devoir(array(
				'professeur' => $user,
				'classe' => unserialize(base64_decode($request->postData('classe'))),
				'libelle' => $request->postData('libelle'),
				'enonce' => $request->postData('enonce'),
				'dateMax' => $date
			));
		
			if($devoir->isValid()) {
				$record = $this->managers->getManagerOf('Devoir')->save($devoir);
				if($record instanceof \Library\Entities\Devoir)
				{
					$this->app->user()->setFlash('success','<strong>Devoir enregistré !</strong>');
					if(!is_dir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id()))
					{
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id(), 0777);
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id()."/pieces_jointes", 0777);
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id()."/rendus", 0777);
						if($record->rendus() && is_array($record->rendus()))
						{
							foreach ($record->rendus() as $key) {
								mkdir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id()."/rendus/eleve_".$key->eleve()->id(), 0777);
							}
						}
					}
					$this->app->httpResponse()->redirect('/professeur/devoirs');
				}
				else
				{
					$this->app->user()->setFlash('warning','<strong>Problème de création des dossiers</strong>');
				}
			} else {
				$this->page->addVar('devoir', $devoir);
				$this->page->addVar('erreurs', $devoir['erreurs']);
			}
		}
		
		$this->page->addVar('title', 'MyLearn - Nouveau devoir');
		$this->page->addVar('class_devoir', 'active');
	}
	
	public function executeModifier(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'),$this->app->user()->getAttribute('id'),true,NULL,NULL);
		if(($devoir instanceof \Library\Entities\Devoir))
		{
			$this->page->addVar('title', 'MyLearn - Modifier : '.$devoir->libelle());
			$this->page->addVar('class_devoir', 'active');
			$this->page->addVar('devoir', $devoir);
			
			if($request->postExists('annuler')) {
				$this->app->httpResponse()->redirect('/professeur/devoirs');
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
				
				$devoir = new \Library\Entities\Devoir(array(
					'id' => $devoir->id(),
					'classe' => unserialize(base64_decode($request->postData('classe'))),
					'libelle' => $request->postData('libelle'),
					'enonce' => $request->postData('enonce'),
					'dateMax' => $date,
					'dateDevoir' => $devoir->dateDevoir(),
					'rendus' => $devoir->rendus(),
					'active' => $request->postExists('active') && $request->postData('active') == 'on' ? 1 : 0
				));
			
				if($devoir->isValid()) {
					$this->managers->getManagerOf('Devoir')->save($devoir);
					// Vérification de l'existences de dossiers
					if(!is_dir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()))
					{
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id(), 0777);
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/pieces_jointes", 0777);
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/rendus", 0777);
					}
					if($devoir->rendus() && is_array($devoir->rendus()))
					{
						foreach ($devoir->rendus() as $key) {
							if(!is_dir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/rendus/eleve_".$key->eleve()->id()))
							{
								mkdir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/rendus/eleve_".$key->eleve()->id(), 0777);
							}
						}
					}
					//
					$this->app->user()->setFlash('success','Modifications enregistrées');
					$this->app->httpResponse()->redirect('/professeur/devoirs');
				} else {
					$this->page->addVar('devoir', $devoir);
					$this->page->addVar('erreurs', $devoir->erreurs());
				}
			}			
		}
		else if($devoir instanceof \Library\Entities\Error)
		{
			$this->app->user()->setFlash($devoir->type(), $devoir->message());
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
	public function executeShow(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'),$this->app->user()->getAttribute('id'),true,NULL,NULL);
		if(($devoir instanceof \Library\Entities\Devoir))
		{
			$this->page->addVar('title', 'MyLearn - Devoir : '.$devoir->libelle());
			$this->page->addVar('class_devoir', 'active');
			$this->page->addVar('devoir', $devoir);
			$this->page->addVar('note', new \DateTime() > $devoir->dateMax() ? true : false);
			$this->page->updateVar('includes',  __DIR__.'/Views/modal_add_piece.php');
			
			if($request->postExists('ajout_piece'))
			{
				if($request->fileExists('piece'))
				{
					$file = $request->fileData('piece');
					if($file['error'] < 1)
					{
						$move = move_uploaded_file($file['tmp_name'], "../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/pieces_jointes/".$file['name']);
						if($move)
						{
							$piece = new \Library\Entities\Piece(array(
								"libelle" => $file['name'],
								"chemin" => "../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/pieces_jointes/".$file['name'],
								"devoir" => $devoir
							));
							if($piece->isValid())
							{
								$this->managers->getManagerOf('Piece')->ajouterPieceJointe($piece);
								$this->app->user()->setFlash('success','Ajout de pièce jointe réussi');
								$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
							}
							
						}
						else
						{
							$this->app->user()->setFlash('error','Ajout de pièce jointe non réussi');
							$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
						}
					}
				}
			}
			
			if($request->postExists('activer'))
			{
				$devoir->setActive(1);
				$this->managers->getManagerOf('Devoir')->save($devoir);
				
				
				if($devoir->rendus() && is_array($devoir->rendus()))
				{
					$mails = array();
					foreach ($devoir->rendus() as $key)
					{
						$mails[] = $key->eleve()->email();
					}
					$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
					$message = '<h3>Bonjour, élève de '.$devoir->classe()->libelle().'</h3>
									<p class="lead">Vous avez un nouveau devoir de '.$this->app->user()->getAttribute('nom').' '.$this->app->user()->getAttribute('prenom').' à rendre avant le '.$devoir->dateMax()->format('d/m/Y').'</p>
									<p>'.$devoir->libelle().'<br/>
										'.$devoir->enonce().'
									</p>
									<p class="callout">
										Pour accéder au devoir <a href="'.$http.'://'.$_SERVER['HTTP_HOST'].'/devoirs/consulter-'.$devoir->id().'"> cliquez ici!</a>
									</p>';				
	
					$sujet = 'Nouveau devoir';
					$this->app->mail()->setMail($mails);
					$this->app->mail()->setMessage($sujet, $message);
					$this->app->mail()->setSujet($sujet);
	
					$envoi = $this->app->mail()->send();
					if($envoi == 1)
					{
						$this->app->user()->setFlash('success','Activation du devoir et notification réussis');
					}
					else
					{
						$this->app->user()->setFlash('error','Activation du devoir réussie - Erreur d\'envoi SMTP');
					}
				}
				else
				{
					$this->app->user()->setFlash('success','Activation du devoir réussie');
				}				
				$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
			}
			
			if ($request->postExists('supprimer_piece')) {
				if ($request->postExists('check')) {
					$check = $request->postData('check');
					$delete = array();
					for ($i = 0; $i < count($check); $i++) {
						$delete[$i] = unserialize(base64_decode($check[$i]));
					}
					$this->page->addVar('delete', $delete);
					$this->page->updateVar('includes',  __DIR__.'/Views/modal_delete_piece.php');
					$this->page->updateVar('js', "<script>$('#modalDeletePiece').modal('show');</script>");
				} else {
					$this->app->user()->setFlash('warning','<strong>Attention !</strong> Vous devez sélectionner au moins une pièce jointe pour la supprimer');
				}
			}
		}
		else if($devoir instanceof \Library\Entities\Error)
		{
			$this->app->user()->setFlash($devoir->type(),$devoir->message());
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
	public function executeDownload(\Library\HTTPRequest $request)
	{
		if($request->getExists('piece') || $request->getExists('production'))
		{
			$mode = $request->getExists('piece') ? array($request->getData('piece'), true) : array($request->getData('production'),false);
			
			$result = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'), $this->app->user()->getAttribute('id'),true,$mode[0],$mode[1]);
			if(isset($result["devoir"]))
			{
				if($result["devoir"] instanceof \Library\Entities\Devoir)
				{
					if(isset($result["piece"]))
					{
						if($result["piece"] instanceof \Library\Entities\Piece)
						{
							if(file_exists($result["piece"]->chemin()))
							{
								$this->app->httpResponse()->addHeader('Content-Description: File Transfer');
								$this->app->httpResponse()->addHeader('Content-Type: application/octet-stream');
								$this->app->httpResponse()->addHeader('Content-Disposition: attachement; filename='.basename($result["piece"]->chemin()));
								$this->app->httpResponse()->addHeader('Content-Transfer-Encoding: binary');
								$this->app->httpResponse()->addHeader('Expires: 0');
								$this->app->httpResponse()->addHeader('Cache-Control: must-revalidate, post-check=0, pre-check=0');
								$this->app->httpResponse()->addHeader('Pragma: public');
								$this->app->httpResponse()->addHeader('Content-Length: '.filesize($result["piece"]->chemin()));
								readfile($piece->chemin());
								exit;
							}
						}
						else if($result["piece"] instanceof \Library\Entities\Error)
						{
							$this->app->user()->setFlash($result["piece"]->type(),$result["piece"]->type());
							$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
						}
					}
				}
				else if($request["devoir"] instanceof \Library\Entities\Error)
				{
					$this->app->user()->setFlash($result["devoir"]->type(),$result["devoir"]->type());
					$this->app->httpResponse()->redirect('/professeur/devoirs');
				}
			}
		}
	}
		
	
	/**
	*	Méthode permettant de supprimer un devoir après la validation dans la fenêtre modale
	*	@param \Library\HTTPRequest $request 
	*	@return void
	**/
	public function executeSupprimer(\Library\HTTPRequest $request)
	{
		if($request->postExists('valider_suppression'))
		{
			for ($i=0; $i < $request->postData('count'); $i++) { 
				$devoir = unserialize(base64_decode($request->postData('suppr_'.$i)));
				if(is_dir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()))
				{
					\Library\BackController::rmdir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id());
				}
				$this->managers->getManagerOf('Devoir')->delete($devoir);
			}
			$this->app->user()->setFlash('success','<strong>Suppression réussie !</strong>');
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
		else
		{
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
	/**
	*	Méthode permettant de supprimer une pièce jointe d'un devoir
	*	@param \Library\HTTPRequest $request 
	*	@return void
	**/
	public function executeDelPiece(\Library\HTTPRequest $request)
	{
		if($request->postExists('supprimer_piece')) {
			for ($i=0; $i < $request->postData('count'); $i++) {
				$piece = unserialize(base64_decode($request->postData('suppr_'.$i)));
				unlink($piece->chemin());
				$this->managers->getManagerOf('Piece')->deletePJ($piece);
			}
			$this->app->user()->setFlash('success','<strong>Suppression réussie !</strong>');
			$this->app->httpResponse()->redirect('/professeur/devoirs/'.$request->postData('devoir'));
		} else {
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
}
?>