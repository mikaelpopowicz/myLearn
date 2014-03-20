<?php
namespace Library\Models;

use \Library\Entities\Assigner;

abstract class AssignerManager extends \Library\Manager
{
	/**
	* Méthode permettant de retourner la liste des matières d'une classe
	* @param $classe int Identifiant de la classe
	* @return $listeAssigner array
	*/
	abstract public function getListOf($classe);
	
	/**
	* Méthode permettant de retourner le compte de matière d'une classe
	* @param $classe int Identifiant de la classe
	* @return $count int
	*/
	abstract public function countOf($classe);
	
	/**
	* Méthode permettant d'ajouter une matière dans une classe
	* @param $assigner Assigner
	* @return void
	*/
	abstract public function add(Assigner $assigner);
	
	/**
	* Méthode permettant de supprimer une matière d'une classe
	* @param $assigner Assigner
	* @return void
	*/
	abstract public function delete(Assigner $etre);
}
?>