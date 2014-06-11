<?php
namespace Library;
 
session_start();
 
class User extends ApplicationComponent
{
	public function getAttribute($attr)
	{
		return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
	}
   
	public function getFlash()
	{
		$flash = $_SESSION['flash'];
		unset($_SESSION['flash']);
     
		return $flash;
	}
	
	public function getQuery()
	{
		$query = $_SESSION['query'];
		unset($_SESSION['query']);
     
		return $query;
	}
	
	public function hasQuery()
	{
		return isset($_SESSION['query']);
	}
   
	public function hasFlash()
	{
		return isset($_SESSION['flash']);
	}
   
	public function isAuthenticated()
	{
		return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
	}
   
	public function setAttribute($attr, $value)
	{
		if(isset($_SESSION[$attr]))
		{
			unset($_SESSION[$attr]);
		}
		$_SESSION[$attr] = $value;
	}
   
	public function setAuthenticated($authenticated = true)
	{
		if (!is_bool($authenticated))
		{
			throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
		}
     
		$_SESSION['auth'] = $authenticated;
	}
   
	public function setFlash($type, $message, $timeout = 3500)
	{
		$_SESSION['flash'] = '<script>noty({timeout: '.$timeout.', type: "'.$type.'", layout: "topCenter", text: "'.$message.'"});</script>';
	}
	
	public function setQuery($query) {
		$_SESSION['query'] = $query;
	}
	
	public function delUser() {
		$_SESSION = array();
		session_destroy();
		session_start();
	}
}