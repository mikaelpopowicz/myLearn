<?php
namespace Library;
 
class Keygen extends ApplicationComponent
{
	private $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	private $key,
	$iv;
	
	const KEY_LN = 24;
	const IV_LN = 8;
   
	public function __construct(Application $app)
	{
		parent::__construct($app);
		
		
		
		if($app->name() != 'Install') {
			$this->iv = base64_decode($this->app->config()->get('cryp_iv'));
		} else {
			$this->setIv(mcrypt_create_iv(self::IV_LN, MCRYPT_RAND));
			$this->setKey($this->getNewSalt(self::KEY_LN, false));
		}
	}
	
	// SETTERS //
	
	public function setKey($key)
	{
		$this->key = substr($key, 0, self::KEY_LN);
	}
	
	public function setIv($iv)
	{
		$this->iv = $iv;
	}
	
	// GETTERS //
	
	public function key() { return $this->key; }
	public function iv() { return $this->iv; }
	
	public function getNewSalt($length = 12, $unique = true)
	{
		if($unique == true) {
			$managers = new \Library\Managers('PDO', \Library\PDOFactory::getMysqlConnexion($this->app->config(), $this));
			$manager = $managers->getManagerOf('User');
			$tokens = $manager->getTokens();
		} else {
			$tokens = array();
		}
		
	    // initialiser la variable $salt
	    $salt = "";
	
		//Longueur de la variable contenant les caractère
	    $longueurMax = strlen($this->chars);
	
	    // initialiser le compteur
	    $i = 0;
		
		do {
			$permut = false;
		    // ajouter un caractère aléatoire à $salt jusqu'à ce que $longueur soit atteint
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

	public function encode($str, $key = NULL)
	{
		if($key == NULL) {
			$this->setKey($this->getNewSalt(self::KEY_LN, false));
		}
		$crypted = base64_encode(mcrypt_encrypt(MCRYPT_3DES, $this->key, $str, MCRYPT_MODE_NOFB, $this->iv));
		return array("key" => base64_encode($this->key), "crypted" => $crypted);
		$this->key = "";
	}

	public function decode($str, $key)
	{
		$str = base64_decode($str);
		$this->key = base64_decode($key);
		$decrypted = mcrypt_decrypt(MCRYPT_3DES, $this->key, $str, MCRYPT_MODE_NOFB, $this->iv);
		$this->key = "";
		return $decrypted;
	}
	
	
	public function uriEncode($str)
	{
		return urlencode(str_replace(' ','_',$str));
	}
	
	public function uriDecode($str)
	{
		return str_replace('_',' ',urldecode($str));
	}
}