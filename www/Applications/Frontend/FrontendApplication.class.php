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
			$_SESSION['username'] = "Admin";
			$controller = $this->getController();
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