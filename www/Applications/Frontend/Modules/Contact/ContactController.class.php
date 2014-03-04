<?php
namespace Applications\Frontend\Modules\Contact;
 
class ContactController extends \Library\BackController {
	
	public function executeIndex(\Library\HTTPRequest $request) {
		$nombreCours = $this->app->config()->get('nombre_cours');
		
		// On ajoute une définition pour le titre.
		$this->page->addVar('title', 'Mika-p - Contact');
		$this->page->addVar('class_contact', 'active');
		$this->page->updateVar('js', "<script src='/assets/js/map.js'</script>");

	}
}