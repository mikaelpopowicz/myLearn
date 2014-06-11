<?php
namespace Applications\Frontend\Modules\Devoir;

class DevoirController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Devoirs');
		$this->page->addVar('class_devoir', 'active');
		$devoirs = $this->managers->getManagerOf('Devoir')->getList($this->app->user()->getAttribute('id'), false);
		$this->page->addVar('devoirs',$devoirs);
	}
	
	public function executeShow(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'),$this->app->user()->getAttribute('id'),false);
		if($devoir instanceof \Library\Entities\Devoir)
		{
			$this->page->addVar('devoir', $devoir);
			$this->page->addVar('title', 'MyLearn - '.$devoir->libelle());
			$this->page->addVar('class_devoir', 'active');
			$this->page->updateVar('includes',  __DIR__.'/Views/modal_add_piece.php');
			
			if($request->postExists('ajout_piece'))
			{
				if($request->fileExists('fichier'))
				{
					$file = $request->fileData('fichier');
					if($file['error'] < 1)
					{
						$move = move_uploaded_file($file['tmp_name'], "../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/rendus/eleve_".$this->app->user()->getAttribute('id')."/".$file['name']);
						if($move)
						{
							$piece = new \Library\Entities\Piece(array(
								"libelle" => $file['name'],
								"chemin" => "../Applications/Frontend/Modules/Devoir/Files/".$devoir->dateDevoir()->format('Y')."_".$devoir->id()."/rendus/eleve_".$this->app->user()->getAttribute('id')."/".$file['name'],
								"devoir" => $devoir
							));
							if($piece->isValid())
							{
								$this->managers->getManagerOf('Piece')->ajouterPieceRendu($piece,$this->app->user()->getAttribute('id'));
								$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "success", layout: "topCenter", text: "Ajout de document réussi"});</script>');
								$this->app->httpResponse()->redirect('/devoirs/consulter-'.$devoir->id());
							}
							
						}
						else
						{
							$this->app->user()->setFlash('<script>noty({timeout: 4000, type: "error", layout: "topCenter", text: "Ajout de document non réussi"});</script>');
							$this->app->httpResponse()->redirect('/devoirs/consulter-'.$devoir->id());
						}
					}
				}
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
			$this->app->httpResponse()->redirect('/devoirs');
		}
	}
	
	public function executeDownload(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'), $this->app->user()->getAttribute('id'), false);
		if(($devoir instanceof \Library\Entities\Devoir))
		{
			$piece = null;
			if(is_array($devoir->pieces()) && $devoir->pieces())
			{
				foreach ($devoir->pieces() as $p) {
					if($p->id() == $request->getData('fichier'))
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
					$this->app->httpResponse()->redirect('/devoirs/consulter-'.$devoir->id());
				}
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "error", layout: "topCenter", text: "IL n\'y a aucune piece jointe dans ce devoir"});</script>');
				$this->app->httpResponse()->redirect('/devoirs/consulter-'.$devoir->id());
			}
			
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "'.$devoir->type().'", layout: "topCenter", text: "'.$devoir->message().'"});</script>');
			$this->app->httpResponse()->redirect('/devoirs');
		}
	}
	
	public function executeDocument(\Library\HTTPRequest $request)
	{
		$devoir = $this->managers->getManagerOf('Devoir')->getUnique($request->getData('id'), $this->app->user()->getAttribute('id'), false);
		if(($devoir instanceof \Library\Entities\Devoir))
		{
			$piece = null;
			if(is_array($devoir->rendus()->pieces()) && $devoir->rendus()->pieces())
			{
				foreach ($devoir->rendus()->pieces() as $p) {
					if($p->id() == $request->getData('fichier'))
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
					$this->app->httpResponse()->redirect('/devoirs/consulter-'.$devoir->id());
				}
			}
			else
			{
				$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "error", layout: "topCenter", text: "IL n\'y a aucune piece jointe dans ce devoir"});</script>');
				$this->app->httpResponse()->redirect('/devoirs/consulter-'.$devoir->id());
			}
			
		}
		else
		{
			$this->app->user()->setFlash('<script>noty({timeout: 3500, type: "'.$devoir->type().'", layout: "topCenter", text: "'.$devoir->message().'"});</script>');
			$this->app->httpResponse()->redirect('/devoirs');
		}
	}
	
	public function executeDelDocument(\Library\HTTPRequest $request)
	{
		if($request->postExists('supprimer_piece')) {
			for ($i=0; $i < $request->postData('count'); $i++) {
				$piece = unserialize(base64_decode($request->postData('suppr_'.$i)));
				unlink($piece->chemin());
				$this->managers->getManagerOf('Piece')->deletePR($piece);
			}
			$this->app->user()->setFlash('<script>noty({timeout: 4000,type: "success", layout: "topCenter", text: "<strong>Suppression réussie !</strong>"});</script>');
			$this->app->httpResponse()->redirect('/devoirs/consulter-'.$request->postData('devoir'));
		} else {
			$this->app->httpResponse()->redirect('/devoirs');
		}
	}
}
?>