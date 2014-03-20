<?php
namespace Library\Models;

use \Library\Entities\Etre;

abstract class EtreManager extends \Library\Manager
{
	/**
	* Méthode permettant de retourner la liste des élèves d'une classe
	* @param $classe int Identifiant de la classe
	* @return $listeEtre array
	*/
	abstract public function getListOf($classe);
	
	/**
	* Méthode permettant de retourner le compte d'élève d'une classe
	* @param $classe int Identifiant de la classe
	* @return $count int
	*/
	abstract public function countOf($classe);
	
	/**
	* Méthode permettant d'ajouter un élève dans une classe
	* @param $etre Etre
	* @return void
	*/
	abstract public function add(Etre $etre);
	
	/**
	* Méthode permettant de supprimer un élève d'une classe
	* @param $etre Etre
	* @return void
	*/
	abstract public function delete(Etre $etre);
}
?>