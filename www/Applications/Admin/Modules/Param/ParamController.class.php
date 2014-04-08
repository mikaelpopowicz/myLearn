<?php
namespace Applications\Admin\Modules\Param;

class ParamController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyAdmin - Paramètres');
		//$this->app->config()->setVar("conf_date","01/01/2014");
		//$xml = $this->app->config()->save();
		//$this->page->addVar('xml', $xml[0]);
	}
	
	public function executeInfos(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyAdmin - Modification des informations générales');
		
		if($request->postExists('annuler'))
		{
			$this->app->httpresponse()->redirect('/admin/parametres');
		}
		
		if($request->postExists('modifier')) {
			$infos = array(
				"nom" => $request->postData('nom'),
				"description" => $request->postData('description'),
				"email" => $request->postData('email'),
				"contact" => $request->postData('contact')
			);
			$erreur = array();
			foreach ($infos as $donnee => $value) {
				if(empty($value)) {
					$erreur[] = $donnee;
				}
			}
			if(empty($erreur)) {
				$this->app->config()->setVar('conf_nom',$infos['nom']);
				$this->app->config()->setVar('conf_description',$infos['description']);
				$this->app->config()->setVar('conf_email',$infos['email']);
				$this->app->config()->setVar('conf_contact',$infos['contact']);
				$this->app->config()->save();
				$this->app->httpresponse()->redirect('/admin/parametres');
			} else {
				$this->page->addVar('infos', $infos);
				$this->page->addVar('erreur', $erreur);
			}
		}
	}
	
	public function executeUser(\Library\HTTPRequest $request)
	{
		
	}
}
?>