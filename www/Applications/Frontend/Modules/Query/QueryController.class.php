<?php
namespace Applications\Frontend\Modules\Query;

class QueryController extends \Library\BackController
{

	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'MyLearn - Recherche');
		
		if($request->postExists('query'))
		{
			$query['original'] = $request->postData('query');
			$query['to_search'] = str_replace(' ','+',strtolower($query['original']));
			if(!empty($query['to_search']))
				{
					$this->setView('search');
					$this->executeSearch($query);
				}
		}
	}
	
	public function executeSearch($query)
	{
		$this->page->addVar('title', 'MyLearn - Résultat(s) de la recherche');
		$this->page->addVar('original', $query['original']);
		
		$result = $this->managers->getManagerOf('Cours')->search($query['to_search']);
		
		if($result != false && is_array($result))
		{
			$this->page->addVar('result', $result);
		}
		else
		{
			$this->page->addVar('erreur', $result);
		}
	}
}