<?php
namespace Applications\Admin\Modules\User;

class UserController extends \Library\BackController
{
	public function executeIndexAdministrateur(\Library\HTTPRequest $request)
	{
		$adms = $this->managers->getManagerOf('Administrateur')->getList();
		$this->page->addVar('adm', $adms);
	}
	
	public function executeIndexProfesseurs(\Library\HTTPRequest $request)
	{
		
	}
	
	public function executeIndexEleves(\Library\HTTPRequest $request)
	{
		
	}
}
?>