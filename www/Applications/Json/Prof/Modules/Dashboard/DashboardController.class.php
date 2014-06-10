<?php
namespace Applications\Prof\Modules\Dashboard;

class DashboardController extends \Library\BackController
{
	
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('class_accueil', 'active');
		$this->page->addVar('title', 'MyLearn - Tableau de bord');
	}
}
?>