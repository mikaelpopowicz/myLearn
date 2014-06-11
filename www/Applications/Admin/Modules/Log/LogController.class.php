<?php
namespace Applications\Admin\Modules\Log;

class LogController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$logs = $this->managers->getManagerOf('LogCon')->getList();
		$this->page->addVar('class_log','active');
		$this->page->addVar('class_conn','active');
		$this->page->addVar('title','myAdmin - Logs de connexion');
		$this->page->addVar('logs', $logs);
	}
}
?>