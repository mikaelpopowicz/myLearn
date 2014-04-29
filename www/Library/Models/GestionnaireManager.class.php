<?php
namespace Library\Models;

use \Library\Entities\Gestionnaire;
 
abstract class GestionnaireManager extends \Library\Manager
{
	/**
	* Méthode retournant une liste des utilisateurs
	* @return array La liste des utilisateurs. Chaque entrée est une instance de User.
	*/
	abstract public function getList();
	
	/**
	* Méthode retournant un utilisateur par son ID
	* @param $id int L'identifiant de l'utilisateur à récupérer
	* @return User L'utilisateur demandée
	*/
	abstract public function getUnique($id);
	
	/**
	* Méthode renvoyant le nombre total d'utilisateur.
	* @return int
	*/
	abstract public function count();
	
	/**
	* Méthode permettant d'ajouter un utilisateur.
	* @param $user User L'utilisateur à ajouter
	* @return void
	*/
	abstract protected function add(Gestionnaire $gestionnaire);
	
	/**
	* Méthode permettant de modifier un utilisateur
	* @param $user Byte L'utilisateur à modifier
	* @return void
	*/
	abstract protected function modify(Gestionnaire $gestionnaire);
	
	/**
	* Méthode permettant de supprimer un utilisateur
	* @param $user User L'utilisateur à supprimer
	* @return void
	*/
	abstract public function delete(Gestionnaire $gestionnaire);
	
	/**
	* Méthode permettant d'enregistrer un utilisateur.
	* @param $user User L'utilisateur à enregistrer
	* @see self::add()
	* @see self::modify()
	* @return void
	*/
	public function save(Gestionnaire $gestionnaire)
	{
		$gestionnaire->isNew() ? $this->add($gestionnaire) : $this->modify($gestionnaire);
	}
}