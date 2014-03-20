<?php
namespace Applications\Install;

class InstallApplication extends \Library\Application {
	
	public function __construct() {
		parent::__construct('Install');
	}
	
	public function run() {
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}
?>