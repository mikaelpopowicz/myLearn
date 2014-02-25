<?php
namespace Library\Models;

use \Library\Entities\Classe;
 
abstract class ClasseManager extends \Library\Manager
{
	abstract public function getUnique($id);

	/**
	* Méthode retournant la liste des matières
	* @return array La liste des matières. Chaque entrée est une instance de Matière.
	*/
	abstract public function getList();
	
	/**
	* Méthode permettant d'ajouter une news.
	* @param $news News La news à ajouter
	* @return void
	*/
	abstract protected function add(Classe $classe);

	/**
	* Méthode permettant d'ajouter une news.
	* @param $news News La news à ajouter
	* @return void
	*/
	abstract protected function modify(Classe $classe);
   
	/**
	* Méthode permettant d'enregistrer une news.
	* @param $news News la news à enregistrer
	* @see self::add()
	* @see self::modify()
	* @return void
	*/
	public function save(Classe $classe)
	{
		$classe->isNew() ? $this->add($classe) : $this->modify($classe);
	}
}