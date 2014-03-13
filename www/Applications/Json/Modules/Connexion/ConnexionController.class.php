<?php
namespace Applications\JSON\Modules\Connexion;

class ConnexionController extends \Library\BackController
{
	public function executeConnexion(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Connexion Json');
		$this->page->addVar('no_layout', true);
		$this->setView('index');
		$password = $request->getData('pass');
		$login =  $request->getData('login');
		if (!empty($login) && !empty($password))
		{
			// Vérification du login
			$exists = $this->managers->getManagerOf('User')->getByName($login);
			
			if ($exists != NULL )
			{
				// On vérifie qu'il a le bon mot de passe
				$match = $this->managers->getManagerOf('User')->getByNamePass($login, sha1(md5(sha1(md5($exists['salt'])).sha1(md5($password)).sha1(md5($exists['salt'])))));
				
				if ($match != NULL)
				{
					if ($match['active'] == 0 )
					{
						
					}
					else
					{
						$reponse = array(
							"id" => $match['id'],
							"nom" => $match['nom'],
							"prenom" => $match['prenom'],
							"email" => $match['email']
						);
						$reponse = json_encode($reponse);
						$this->page->addVar('json', $reponse);
					}
				}
			}
		}		
	}
}