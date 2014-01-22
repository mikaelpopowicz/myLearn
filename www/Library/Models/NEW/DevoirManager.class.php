<?php 
namespace Library\Models;

use Library\Entities\Devoir;

abstract class DevoirManager extends \Library\Manager
{
	/**
	* Méthode retournant une liste de devoirs demandée
	* @param $debut int La première devoirs à sélectionner
	* @param $limite int Le nombre de devoirs à sélectionner
	* @return array La liste des devoirs. Chaque entrée est une instance de Devoir.
	*/
	abstract public function getList();
	
	/**
	* Méthode retournant une liste de devoirs demandée
	* @param $devoir Devoir devoir à selectionner
	* @return array La liste des cours du devoir selectionnée
	*/
	abstract public function getListOf($devoir);
	
	/**
	* Méthode retournant un devoir précis.
	* @param $id int L'identifiant du devoir à récupérer
	* @return News La news demandée
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