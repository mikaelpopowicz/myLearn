<?php
namespace Applications\Backend\Modules\Dashboard;

class DashboardController extends \Library\BackController
{
	
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('class_accueil', 'active');
		$this->page->addVar('title', 'ADMika - Tableau de bord');
	}
}
?>