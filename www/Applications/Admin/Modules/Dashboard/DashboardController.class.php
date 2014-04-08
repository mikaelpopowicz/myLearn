<?php
namespace Applications\Admin\Modules\Dashboard;

class DashboardController extends \Library\BackController
{
	
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('class_accueil', 'active');
		$this->page->addVar('title', 'myAdmin - Tableau de bord');

		// Compteur d'installation
		$etape2 = 0;

		$etapes = array('2' => array(
				'section' => array(),
				'session'  => array(),
				'classe' => array(),
				'compteur' => 0
			),
			'3' => array(
				'matiere' => array(),
				'professeur' => array(),
				'eleve' => array(),
				'compteur' => 0
			)
		);

		foreach ($etapes as $key => $value) {
			//echo '<pre>';print_r($key);
			foreach ($value as $section => $val) {
				$label = $key == '2' ? "info" : "warning";
				if($section != 'compteur') {
					if($this->managers->getManagerOf(ucfirst($section))->count() > 0) {
						$etapes[$key][$section]['icon'] = '<span class="pull-right label label-'.$label.'"><i class="fa fa-check"></i> </span>';
						$etapes[$key]['compteur'] += 11.11;

					} else {
						$etapes[$key][$section]['icon'] = '<span class="pull-right label label-danger"><i class="fa fa-spinner fa-spin"></i> </span>';
					}
				}
				switch ($section) {
					case 'section':
						$etapes[$key][$section]['text'] = 'Créer une section';
						break;
					case 'session':
						$etapes[$key][$section]['text'] = 'Créer une session';
						break;
					case 'classe':
						$etapes[$key][$section]['text'] = 'Créer une classe';
						break;
					case 'matiere':
						$etapes[$key][$section]['text'] = 'Créer une matière';
						break;
					case 'professeur':
						$etapes[$key][$section]['text'] = 'Ajouter un professeur';
						break;
					case 'eleve':
						$etapes[$key][$section]['text'] = 'Ajouter un élève';
						break;
				}
			}
		}

		$this->page->addVar('etapes', $etapes);
		$this->page->addVar('section', $this->managers->getManagerOf('Section'));
		$this->page->addVar('session', $this->managers->getManagerOf('Session'));
		$this->page->addVar('classe', $this->managers->getManagerOf('Classe'));
		$this->page->addVar('matiere', $this->managers->getManagerOf('Matiere'));
		$this->page->addVar('cours', $this->managers->getManagerOf('Cours'));
		$this->page->addVar('devoir', $this->managers->getManagerOf('Devoir'));
		$this->page->addVar('admin', $this->managers->getManagerOf('Administrateur'));
		$this->page->addVar('prof', $this->managers->getManagerOf('Professeur'));
		$this->page->addVar('eleve', $this->managers->getManagerOf('Eleve'));
	}
}
?>