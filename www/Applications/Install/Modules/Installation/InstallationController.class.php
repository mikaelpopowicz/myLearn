<?php
namespace Applications\Install\Modules\Installation;

class InstallationController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myLearn - Première installation');
	}
	
	public function executeInit1(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'myLearn - Vérifications');
		$php = phpversion();
		$php = explode('.', $php);
		$php = ($php[0] >= 5 && $php[1] >= 2) ? '<span class="label label-success"><i class="fa fa-check"></i> </span>' : "<span class='badge badge-danger'>X</span>";
		$test =  "../".__DIR__;
		fopen ('../../test.php', 'r');
		$conf = is_writable('../../../Frontend/Config') ? '<span class="label label-success"><i class="fa fa-check"></i> </span>' : "<span class='label label-danger'><i class='fa fa-times'></i> </span>";
		
		$this->page->addVar('php', $php);
		$this->page->addVar('conf', $conf);
	}
	
	public function executeInit2(\Library\HTTPRequest $request)
	{
		
	}
	
	public function executeInit3(\Library\HTTPRequest $request)
	{
		
	}
}
?>