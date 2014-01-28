<?php
namespace Applications\Admin\Modules\Dashboard;

class DashboardController extends \Library\BackController
{
	
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('class_accueil', 'active');
		$this->page->addVar('title', 'myAdmin - Tableau de bord');
		$this->page->addVar('nom', $this->app->config()->get('conf_nom'));
		$this->page->addVar('desc', $this->app->config()->get('conf_description'));
		$this->page->addVar('hote', $this->app->config()->get('db_host'));
		$this->page->addVar('base', $this->app->config()->get('db_name'));
		$this->page->addVar('db_user', $this->app->config()->get('db_user'));
	}
}
?>