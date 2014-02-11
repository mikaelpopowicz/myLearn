<?php
namespace Applications\Frontend;

class FrontendApplication extends \Library\Application {
	
	public function __construct() {
		parent::__construct();
		
		$this->name = "Frontend";
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
				}
				
			}
		}
		else
		{
			if($controller->action() != 'activate' && $controller->action() != 'newPass' && $controller->action() != 'passReload') {
				$controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
			}			
		}
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}
?>