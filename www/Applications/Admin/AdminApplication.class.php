<?php
namespace Applications\Admin;
 
class AdminApplication extends \Library\Application
{
	public function __construct()
	{
		parent::__construct();
     
		$this->name = 'Admin';
	}
   
	public function run()
	{
		if ($this->user->isAuthenticated())
		{
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