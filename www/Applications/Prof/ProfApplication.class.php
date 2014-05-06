<?php
namespace Applications\Prof;
 
class ProfApplication extends \Library\Application
{
	public function __construct($start)
	{
		parent::__construct('Prof',$start);
	}
   
	public function run()
	{
		if ($this->user->isAuthenticated() && $this->user()->getAttribute('status') == 'Prof')
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