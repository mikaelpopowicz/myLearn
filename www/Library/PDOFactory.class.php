<?php
namespace Library;
 
class PDOFactory
{	
	public static function getMysqlConnexion(\Library\Config $cf)
	{
		$host = $cf->get('db_host');
		$name = $cf->get('db_name');
		$user = $cf->get('db_user');
		$pass = $cf->get('db_user_pass');
		try {
			$db = new \PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);
			$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
			$db = NULL;
		}
		return $db;
	}
}