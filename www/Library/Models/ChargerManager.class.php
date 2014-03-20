<?php
namespace Library\Models;

use \Library\Entities\Charger;

abstract class ChargerManager extends \Library\Manager
{
	/**
	* Méthode permettant de retourner la liste des professeurs d'une classe
	* @param $classe int Identifiant de la classe
	* @return $listeCharger array
	*/
	abstract public function getListOf($classe);
	
	/**
	* Méthode permettant de retourner le compte de professeur d'une classe
	* @param $classe int Identifiant de la classe
	* @return $count int
	*/
	abstract public function countOf($classe);
	
	/**
	* Méthode permettant d'ajouter un professeur dans une classe
	* @param $charger Charger
	* @return void
	*/
	abstract public function add(Charger $charger);
	
	/**
	* Méthode permettant de supprimer un professeur d'une classe
	* @param $charger Charger
	* @return void
	*/
	abstract public function delete(Charger $charger);
}
?>