<?php
namespace Library\Models;

use \Library\Entities\User;
 
abstract class UserManager extends \Library\Manager
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
	* Méthode servant à l'identification
	* @param $name string Username de l'utilisateur
	* @param $pass string Mot de passe déjà hashé pour vérifier en BDD
	* @return User L'utilisateur si il existe et le pass est correct
	*/
	abstract public function getByNamePass($name, $pass);
	
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
	abstract protected function add(User $user);
	
	/**
	* Méthode permettant de modifier un utilisateur
	* @param $user Byte L'utilisateur à modifier
	* @return void
	*/
	abstract protected function modify(User $user);
	
	/**
	* Méthode permettant de supprimer un utilisateur
	* @param $user User L'utilisateur à supprimer
	* @return void
	*/
	abstract public function delete(User $user);
	
	/**
	* Méthode permettant d'enregistrer un utilisateur.
	* @param $user User L'utilisateur à enregistrer
	* @see self::add()
	* @see self::modify()
	* @return void
	*/
	public function save(User $user)
	{
		if ($user->isValid())
		{
			$user->isNew() ? $this->add($user) : $this->modify($user);
		}
		else
		{
			throw new \RuntimeException('L\'utilisateur doit être validée pour être enregistrée');
		}
	}
}