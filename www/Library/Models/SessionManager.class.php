<?php
namespace Library\Models;

use \Library\Entities\Session;
 
abstract class SessionManager extends \Library\Manager
{
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
	abstract protected function add(Session $section);

	/**
	* Méthode permettant d'ajouter une news.
	* @param $news News La news à ajouter
	* @return void
	*/
	abstract protected function modify(Session $section);
   
	/**
	* Méthode permettant d'enregistrer une news.
	* @param $news News la news à enregistrer
	* @see self::add()
	* @see self::modify()
	* @return void
	*/
	public function save(Session $section)
	{
		$section->isNew() ? $this->add($section) : $this->modify($section);
	}
}