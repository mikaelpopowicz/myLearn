<?php
namespace Library;
 
class PDOFactory
{	
	public static function getMysqlConnexion(\Library\Config $cf, \Library\Keygen $key)
	{
		$host = $key->decode($cf->get('db_host'), $cf->get('cryp_key'));
		$name = $key->decode($cf->get('db_name'), $cf->get('cryp_key'));
		$user = $key->decode($cf->get('db_user'), $cf->get('cryp_key'));
		$pass = $key->decode($cf->get('db_user_pass'), $cf->get('cryp_key'));
		$db = new \PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
     
		return $db;
	}
}