<?php
namespace Library\Models;

use \Library\Entities\Charger;

abstract class ChargerManager extends \Library\Manager
{
	/**
	* Méthode retournant une liste
	* @param $classe int
	* @return array
	*/
	abstract public function getListOf($classe);

	/**
	* Méthode permettant de récupérer une instance.
	* @param $classe int
	* @param $prof int
	* @return $charger Charger
	*/
	abstract protected function getUnique($classe, $prof);

	/**
	* Méthode permettant d'ajouter.
	* @param $charger Charger
	* @return void
	*/
	abstract protected function add(Charger $charger);

	/**
	* Méthode permettant de supprimer.
	* @param $charger Charger
	* @return void
	*/
	abstract protected function delete(Charger $charger);
}
?>