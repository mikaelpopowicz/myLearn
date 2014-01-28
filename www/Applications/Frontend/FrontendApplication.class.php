<?php
namespace Applications\Frontend;

class FrontendApplication extends \Library\Application {
	
	public function __construct() {
		parent::__construct();
		
		$this->name = "Frontend";
	}
	
	public function run() {
		if ($this->user->isAuthenticated())
		{
			$controller = $this->getController();
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
			$controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
		}
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}
?>