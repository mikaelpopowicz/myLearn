<?php
namespace Applications\Json;
 
class JsonApplication extends \Library\Application
{
	public function __construct()
	{
		parent::__construct('JSON');
	}
   
	public function run()
	{
		$controller = $this->getController();     
		$controller->execute();
     
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}