<?php
namespace Library;
 
class Keygen extends ApplicationComponent
{
	protected $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
   
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}
	
	public function getNewSalt($length = 12)
	{
		$managers = new \Library\Managers('PDO', \Library\PDOFactory::getMysqlConnexion());
		$manager = $managers->getManagerOf('Byte');
		$tokens = $manager->getTokens();
	    // initialiser la variable $mdp
	    $salt = "";
	
		//Longueur de la variable contenant les caractère
	    $longueurMax = strlen($this->chars);
	
	    // initialiser le compteur
	    $i = 0;
		
		do {
			$permut = false;
		    // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
		    while ($i < $length) {
		        // prendre un caractère aléatoire
		        $occurence = substr($this->chars, mt_rand(0, $longueurMax-1), 1);
				$salt .= $occurence;
		 	   $i++;
		    }
			foreach($tokens as $token) {
				if ($token == $salt) {
					$permut = true;
				}
			}
		} while ($permut = false);
		 
	    return $salt;
	}
	
}