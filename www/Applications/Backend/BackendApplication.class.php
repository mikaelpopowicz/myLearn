<?php
namespace Applications\Backend;
 
class BackendApplication extends \Library\Application
{
	public function __construct()
	{
		parent::__construct();
     
		$this->name = 'Backend';
	}
   
	public function run()
	{
		if ($this->user->isAuthenticated())
		{
			$_SESSION['username'] = "Admin";
			$controller = $this->getController();
		}
		else
		{
			//$this->httpResponse->redirect('/admin');
			$controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
		}
     
		$controller->execute();
     
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}