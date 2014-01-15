<?php
namespace Library\Models;

use \Library\Entities\Matiere;
 
abstract class MatiereManager extends \Library\Manager
{
	/**
	* Méthode retournant la liste des matières
	* @return array La liste des matières. Chaque entrée est une instance de Matière.
	*/
	abstract public function getList();
	
	/**
	* Méthode permettant d'ajouter une news.
	* @param $libelle Le libelle de la matière à recherher
	* @return void
	*/
	abstract public function getByName($libelle);
	
	/**
	* Méthode permettant d'ajouter une news.
	* @param $news News La news à ajouter
	* @return void
	*/
	abstract protected function add(Matiere $matiere);
   
	/**
	* Méthode permettant d'enregistrer une news.
	* @param $news News la news à enregistrer
	* @see self::add()
	* @see self::modify()
	* @return void
	*/
	public function save(Matiere $matiere)
	{
		$matiere->isNew() ? $this->add($matiere) : $this->modify($matiere);
	}
}