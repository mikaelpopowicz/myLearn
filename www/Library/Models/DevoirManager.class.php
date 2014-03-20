<?php 
namespace Library\Models;
use Library\Entities\Devoir;
abstract class DevoirManager extends \Library\Manager
{
	/**
	* Méthode retournant une liste de devoirs demandée
	* @return array La liste des devoirs. Chaque entrée est une instance de Devoir.
	*/
	abstract public function getList();
	
	/**
	* Méthode retournant une liste de devoirs demandée d'une classe
	* @param $classe int La classe dont on veut les devoirs
	* @return array La liste des devoirs de la classe selectionnée
	*/
	abstract public function getListOf($classe);
	
	/**
	* Méthode retournant une liste de devoirs demandée d'un professeur
	* @param $prof int Le professeur dont on veut les devoirs
	* @return array La liste des devoirs du professeur selectionné
	*/
	abstract public function getListOfTeacher($prof);
	
	/**
	* Méthode retournant un devoir précis.
	* @param $id int L'identifiant du devoir à récupérer
	* @return Devoir Le devoir demandée
	*/
	abstract public function getUnique($id);
	
	/**
	* Méthode renvoyant le nombre de devoirs total.
	* @return int
	*/
	abstract public function count();
	
	/**
	* Méthode permettant d'ajouter un devoir.
	* @param $devoir Devoir Le devoir à ajouter
	* @return void
	*/
	abstract protected function add(Devoir $devoir);
	
	/**
	* Méthode permettant d'enregistrer un devoir
	* @param $devoir Devoir Le devoir à enregistrer
	* @return void
	*/
	abstract protected function modify(Devoir $devoir);
   
	/**
	* Méthode permettant d'enregistrer un devoir.
	* @param $devoir Devoir le devoir à enregistrer
	* @see self::add()
	* @see self::modify()
	* @return void
	*/
	public function save(Devoir $devoir)
	{
		$devoir->isNew() ? $this->add($devoir) : $this->modify($devoir);
	}
}