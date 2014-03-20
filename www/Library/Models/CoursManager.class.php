<?php
namespace Library\Models;

use \Library\Entities\Cours;
 
abstract class CoursManager extends \Library\Manager
{
	/**
	* Méthode retournant une liste de news demandée
	* @param $debut int La première news à sélectionner
	* @param $limite int Le nombre de news à sélectionner
	* @return array La liste des news. Chaque entrée est une instance de News.
	*/
	abstract public function getList();
	
	/**
	* Méthode retournant une liste de news demandée
	* @param $matiere Matiere matière à selectionner
	* @return array La liste des cours de la matière selectionnée
	*/
	abstract public function getListOf($matiere);
	
	/**
	* Méthode retournant une news précise.
	* @param $id int L'identifiant de la news à récupérer
	* @return News La news demandée
	*/
	abstract public function getUnique($id);
	
	/**
	* Méthode renvoyant le nombre de news total.
	* @return int
	*/
	abstract public function count();
	
	/**
	* Méthode permettant d'ajouter une news.
	* @param $news News La news à ajouter
	* @return void
	*/
	abstract protected function add(Cours $cours);
	
	/**
	* Méthode permettant d'enregistrer un cours
	* @param $cours Cours Le cours à enregistrer
	* @return void
	*/
	abstract protected function modify(Cours $cours);
   
	/**
	* Méthode permettant d'enregistrer une news.
	* @param $news News la news à enregistrer
	* @see self::add()
	* @see self::modify()
	* @return void
	*/
	public function save(Cours $cours)
	{
		if ($cours->isValid())
		{
			$cours->isNew() ? $this->add($cours) : $this->modify($cours);
		}
		else
		{
			throw new \RuntimeException('Le cours doit être validée pour être enregistrée');
		}
	}
}