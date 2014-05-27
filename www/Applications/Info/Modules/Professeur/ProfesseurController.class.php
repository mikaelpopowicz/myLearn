<?php
namespace Applications\Info\Modules\Professeur;

class ProfesseurController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$tab=array(
			'1'=>'un',
			'2'=>'deux',
			'3'=>'trois'
		);
		
		if ($request->postExists('buttonTest')) 
		{
			$var = $request->postData('test');
			$var1 = $request->postData('test1');
			$this->page->addVar('test', $var+$var1);
			
		}
		$this->page->addVar('title', 'unNom');
		$this->page->addVar('toto', $tab);
	}
}

?>