<?php
namespace Applications\Frontend\Modules\Tutos;
 
class TutosController extends \Library\BackController {
	
	public function executeIndex(\Library\HTTPRequest $request) {
		
		$this->page->addVar('title', 'Mika-p - tutos');
		$this->page->addVar('class_tutos', 'active');
	}
}