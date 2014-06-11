<?php
namespace Library\Models;

use \Library\Entities\LogCon;
 
abstract class LogConManager extends \Library\Manager
{
	/**
	* Méthode permettant la construction automatique de l'objet et de ses composants s'il en a
	* @param \PDO $requete
	* @return \Library\Entities\LogCon
	*/
	abstract public function getObj($requete);
	
	/**
	* Méthode retournant la liste des matières
	* @return array La liste des matières. Chaque entrée est une instance de Matière.
	*/
	abstract public function getList();
}