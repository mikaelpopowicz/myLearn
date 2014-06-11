<?php 
namespace Library\Models;
use Library\Entities\Devoir;
abstract class DevoirManager extends \Library\Manager
{
	
	/**
	* Méthode retournant un devoir précis.
	* @param $id int L'identifiant du devoir à récupérer
	* @return Devoir Le devoir demandée
	*/
	abstract public function getUnique($id, $user, $prof, $piece, $jointe);
	
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
		$result = $devoir->isNew() ? $this->add($devoir) : $this->modify($devoir);
		return $result;
	}
}