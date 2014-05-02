<?php
namespace Applications\JSON\Modules\Connexion;

class ConnexionController extends \Library\BackController
{	
	public function executeConnexion(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Connexion Json');
		$this->page->addVar('no_layout', true);
		$this->setView('index');
		$login = $request->getData('login');
		$pass = $request->getData('pass');
		if (!empty($login) && !empty($pass))
		{
			$user = $this->managers->getManagerOf('User')->connexion($login,$pass);
			
			if(isset($user['user']) && ($user['user'] instanceof \Library\Entities\User))
			{
				if($user['user']->active())
				{
					$reponse = array(
						"logged" => true,
						"id" => $user['user']['id'],
						"nom" => $user['user']['nom'],
						"prenom" => $user['user']['prenom'],
						"email" => $user['user']['email']
					);
					$reponse = json_encode($reponse);
					$this->page->addVar('json', $reponse);
				}
				else
				{
					$reponse = array(
						"logged" => false,
						"erreur" => $user['Message']
					);
					$reponse = json_encode($reponse);
					$this->page->addVar('json', $reponse);
				}
			}
			else
			{
				$reponse = array(
					"logged" => false,
					"erreur" => $user['Message']
				);
				$reponse = json_encode($reponse);
				$this->page->addVar('json', $reponse);
			}
		}		
	}
	public function executeIndex(\Library\HTTPRequest $request)
	{
		
	}
}