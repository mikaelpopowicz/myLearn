<?php
namespace Applications\Frontend\Modules\Travaux;
 
class TravauxController extends \Library\BackController {
	
	public function executeIndex(\Library\HTTPRequest $request) {
		
		$this->page->addVar('title', 'Mika-p - Travaux SLAM');
		$this->page->addVar('class_travaux', 'active');
	}
}