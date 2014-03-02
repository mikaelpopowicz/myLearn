<?php
namespace Library\Models;

use \Library\Entities\Crypt;
 
abstract class CryptManager extends \Library\Manager
{
	/**
	* Méthode retournant un utilisateur par son ID
	* @param $id int L'identifiant de l'utilisateur à récupérer
	* @return User L'utilisateur demandée
	*/
	abstract public function getUnique($token);
	
	/**
	* Méthode permettant d'ajouter un utilisateur.
	* @param $user User L'utilisateur à ajouter
	* @return void
	*/
	abstract public function add(Crypt $crypt);	
}