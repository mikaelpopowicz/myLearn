<?php
namespace Applications\Admin;
 
class AdminApplication extends \Library\Application
{
	public function __construct()
	{
		parent::__construct('Admin');
     
		$this->mail = new \Library\Mailer($this);
	}
   
	public function run()
	{
		if ($this->user->isAuthenticated() && $this->user->getAttribute('status') == 'Admin')
		{
			$controller = $this->getController();
		}
		else
		{
			$this->httpResponse->redirect('/');
		}
     
		$controller->execute();
     
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}