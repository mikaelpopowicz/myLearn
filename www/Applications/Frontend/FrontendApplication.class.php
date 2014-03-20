<?php
namespace Applications\Frontend;

class FrontendApplication extends \Library\Application {
	
	public function __construct() {
		parent::__construct('Frontend');
		$this->mail = new \Library\Mailer($this);
	}
	
	public function run() {
		$controller = $this->getController();
		if ($this->user->isAuthenticated())
		{
			if($controller->action() != 'logout') {
				if($this->user->getAttribute('status') == 'Prof') {
					$this->httpResponse->redirect('/professeur');
				} else if($this->user->getAttribute('status') == 'Admin') {
					$this->httpResponse->redirect('/admin');
				} else if($this->user->getAttribute('status') == 'Eleve' && count($this->user->getAttribute('classes')) < 1) {
					$this->httpResponse->redirect503();
				}
			}
			$controller->execute();
		}
		else
		{
			if($controller != false) {
				if($controller->action() == 'activate' || $controller->action() == 'newPass' || $controller->action() == 'passReload') {
					$controller->execute();
				} else {
					$controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
					$controller->execute();
				}
			} else {
				$this->httpResponse->redirect('/');
			}
		}
		
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}
?>