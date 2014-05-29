<?php
namespace Applications\Install;

class InstallApplication extends \Library\Application {
	
	public function __construct($start) {
		parent::__construct('Install',$start);
		$this->mail = new \Library\Mailer($this);
	}
	
	public function run() {
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}
?>