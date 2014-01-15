<?php
namespace Library;
 
class PDOFactory
{	
	public static function getMysqlConnexion(\Library\Config $cf)
	{
		$db = new \PDO('mysql:host='.$cf->get('db_host').';dbname='.$cf->get('db_name'), $cf->get('db_user'), $cf->get('db_user_pass'));
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
     
		return $db;
	}
}