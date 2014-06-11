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
					$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous ne pouvez modifier qu\'un devoir à la fois"});</script>');
				} else {
					$this->app->httpResponse()->redirect('/professeur/devoirs/modifier-'.unserialize(base64_decode($check[0]))->id());
				}
			} else {
				$this->app->user()->setFlash('<script>noty({type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un devoir pour le modifier"});</script>');
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
				$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins un devoir pour le supprimer"});</script>');
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
				//echo '<pre>';print_r($record);die('</pre>');
				if($record instanceof \Library\Entities\Devoir)
				{
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "success", layout: "topCenter", text: "<strong>Devoir enregistré !</strong>"});</script>');
					if(!is_dir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id()))
					{
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id(), 0777);
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id()."/pieces_jointes", 0777);
						mkdir("../Applications/Frontend/Modules/Devoir/Files/".date('Y')."_".$record->id()."/rendus", 0777);
						if(is_array($record->rendus()) && !$record->rendus())
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
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "<strong>Problème de création des dossiers</strong>"});</script>');
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
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'));
		if(($devoir instanceof \Library\Entities\Devoir) && $devoir->professeur()->id() == $this->app->user()->getAttribute('id'))
		{
			$oldAct = $devoir->active();
			$rendus = $devoir->rendus();
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
					'active' => $request->postExists('active') && $request->postData('active') == 'on' ? 1 : 0
				));
			
				if($devoir->isValid()) {
					$this->managers->getManagerOf('Devoir')->save($devoir);
					if($oldAct == 0 && $devoir->active() == 1)
					{
						$mails = array();
						foreach ($rendus as $key) {
							$mails[] = $key->eleve()->email();
						}
						$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
						$message = '<h3>Bonjour, élève de '.$devoir->classe()->libelle().'</h3>
										<p class="lead">Vous avez un nouveau devoir de '.$this->app->user()->getAttribute('nom').' '.$this->app->user()->getAttribute('prenom').' à rendre avant le '.$devoir->dateMax()->format('d/m/Y').'</p>
										<p>'.$devoir->libelle().'<br/>
											'.$devoir->enonce().'
										</p>
										<p class="callout">
											Pour accéder au devoir <a href="'.$http.'://'.$_SERVER['HTTP_HOST'].'/devoirs/'.$devoir->id().'"> cliquez ici!</a>
										</p>';				
			
						$sujet = 'Nouveau devoir';
						$this->app->mail()->setMail($mails);
						$this->app->mail()->setMessage($sujet, $message);
						$this->app->mail()->setSujet($sujet);
			
						$envoi = $this->app->mail()->send();
						if($envoi == 1)
						{
							$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "success", layout: "topCenter", text: "Activation du devoir réussie"});</script>');
						}
						else
						{
							$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "error", layout: "topCenter", text: "Modifications réussies - '.$envoi.'"});</script>');
						}
					}
					
					$this->app->httpResponse()->redirect('/professeur/devoirs');
				} else {
					$this->page->addVar('devoir', $devoir);
					$this->page->addVar('erreurs', $devoir->erreurs());
				}
			}
			
			$this->page->addVar('title', 'MyLearn - Modifier : '.$devoir->libelle());
			$this->page->addVar('class_devoir', 'active');
			$this->page->addVar('devoir', $devoir);
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "'.$devoir->type().'", layout: "topCenter", text: "'.$devoir->message().'"});</script>');
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
	public function executeShow(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'),$this->app->user()->getAttribute('id'),true);
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
								$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "success", layout: "topCenter", text: "Ajout de pièce jointe réussi"});</script>');
								$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
							}
							
						}
						else
						{
							$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "error", layout: "topCenter", text: "Ajout de pièce jointe non réussi"});</script>');
							$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
						}
					}
				}
			}
			
			if($request->postExists('activer'))
			{
				$devoir->setActive(1);
				$this->managers->getManagerOf('Devoir')->save($devoir);
				$rendus = $devoir->rendus();
				$mails = array();
				foreach ($rendus as $key) {
					$mails[] = $key->eleve()->email();
				}
				$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
				$message = '<h3>Bonjour, élève de '.$devoir->classe()->libelle().'</h3>
								<p class="lead">Vous avez un nouveau devoir de '.$this->app->user()->getAttribute('nom').' '.$this->app->user()->getAttribute('prenom').' à rendre avant le '.$devoir->dateMax()->format('d/m/Y').'</p>
								<p>'.$devoir->libelle().'<br/>
									'.$devoir->enonce().'
								</p>
								<p class="callout">
									Pour accéder au devoir <a href="'.$http.'://'.$_SERVER['HTTP_HOST'].'/devoirs/'.$devoir->id().'"> cliquez ici!</a>
								</p>';				
	
				$sujet = 'Nouveau devoir';
				$this->app->mail()->setMail($mails);
				$this->app->mail()->setMessage($sujet, $message);
				$this->app->mail()->setSujet($sujet);
	
				$envoi = $this->app->mail()->send();
				if($envoi == 1)
				{
					$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "success", layout: "topCenter", text: "Activation du devoir réussie"});</script>');
				}
				else
				{
					$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "error", layout: "topCenter", text: "Modifications réussies - Erreur d\'envoi SMTP"});</script>');
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
					$this->app->user()->setFlash('<script>noty({timeout: 3000, type: "warning", layout: "topCenter", text: "<strong>Attention !</strong> Vous devez sélectionner au moins une pièce jointe pour la supprimer"});</script>');
				}
			}
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "'.$devoir->type().'", layout: "topCenter", text: "'.$devoir->message().'"});</script>');
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
	public function executeDownload(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'), $this->app->user()->getAttribute('id'), true);
		if(($devoir instanceof \Library\Entities\Devoir))
		{
			$piece = null;
			$pieces = $devoir->pieces();
			foreach ($pieces as $p) {
				if($p->id() == $request->getData('piece'))
				{
					$piece = $p;
				}
			}
			if($piece instanceof \Library\Entities\Piece)
			{
				if(file_exists($piece->chemin()))
				{
					$this->app->httpResponse()->addHeader('Content-Description: File Transfer');
					$this->app->httpResponse()->addHeader('Content-Type: application/octet-stream');
					$this->app->httpResponse()->addHeader('Content-Disposition: attachement; filename='.basename($piece->chemin()));
					$this->app->httpResponse()->addHeader('Content-Transfer-Encoding: binary');
					$this->app->httpResponse()->addHeader('Expires: 0');
					$this->app->httpResponse()->addHeader('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					$this->app->httpResponse()->addHeader('Pragma: public');
					$this->app->httpResponse()->addHeader('Content-Length: '.filesize($piece->chemin()));
					readfile($piece->chemin());
					exit;
				}
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "error", layout: "topCenter", text: "Pièce jointe inconnue"});</script>');
				$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
			}
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "'.$devoir->type().'", layout: "topCenter", text: "'.$devoir->message().'"});</script>');
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
	public function executeDocument(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'), $this->app->user()->getAttribute('id'), true);
		if(($devoir instanceof \Library\Entities\Devoir))
		{
			$piece = null;
			if(is_array($devoir->rendus()) && $devoir->rendus())
			{
				foreach ($devoir->rendus() as $rendu) {
					if(is_array($rendu->pieces()) && $rendu->pieces())
					{
						foreach ($rendu->pieces() as $p) {
							if($p->id() == $request->getData('fichier'))
							{
								$piece = $p;
							}
						}	
					}
				}
				if($piece instanceof \Library\Entities\Piece)
				{
					if(file_exists($piece->chemin()))
					{
						$this->app->httpResponse()->addHeader('Content-Description: File Transfer');
						$this->app->httpResponse()->addHeader('Content-Type: application/octet-stream');
						$this->app->httpResponse()->addHeader('Content-Disposition: attachement; filename='.basename($piece->chemin()));
						$this->app->httpResponse()->addHeader('Content-Transfer-Encoding: binary');
						$this->app->httpResponse()->addHeader('Expires: 0');
						$this->app->httpResponse()->addHeader('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						$this->app->httpResponse()->addHeader('Pragma: public');
						$this->app->httpResponse()->addHeader('Content-Length: '.filesize($piece->chemin()));
						readfile($piece->chemin());
						exit;
					}
				}
				else
				{
					$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "error", layout: "topCenter", text: "Pièce jointe inconnue"});</script>');
					$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
				}
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "error", layout: "topCenter", text: "IL n\'y a aucune piece jointe dans ce devoir"});</script>');
				$this->app->httpResponse()->redirect('/professeur/devoirs/'.$devoir->id());
			}
			
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "'.$devoir->type().'", layout: "topCenter", text: "'.$devoir->message().'"});</script>');
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
	public function executeSupprimer(\Library\HTTPRequest $request)
	{
		for ($i=0; $i < $request->postData('count'); $i++) { 
			$devoir = unserialize(base64_decode($request->postData('suppr_'.$i)));
			if(is_dir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()))
			{
				\Library\BackController::rmdir("../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id());
			}
			$this->managers->getManagerOf('Devoir')->delete($devoir);
		}
		$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
		$this->app->httpResponse()->redirect('/professeur/devoirs');
	}
	
	public function executeDelPiece(\Library\HTTPRequest $request)
	{
		if($request->postExists('supprimer_piece')) {
			for ($i=0; $i < $request->postData('count'); $i++) {
				$piece = unserialize(base64_decode($request->postData('suppr_'.$i)));
				unlink($piece->chemin());
				$this->managers->getManagerOf('Piece')->deletePJ($piece);
			}
			$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
			$this->app->httpResponse()->redirect('/professeur/devoirs/'.$request->postData('devoir'));
		} else {
			$this->app->httpResponse()->redirect('/professeur/devoirs');
		}
	}
	
}
?>