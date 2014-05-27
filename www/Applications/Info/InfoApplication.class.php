<?php
namespace Applications\Info;

class InfoApplication extends \Library\Application {
	
	public function __construct($start)
	{
		parent::__construct('Info',$start);
	}
	
	public function run() 
	{
		$controller = $this->getController();
		$controller->execute();
		
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}
?>