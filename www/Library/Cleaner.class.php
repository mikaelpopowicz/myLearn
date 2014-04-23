<?php
namespace Library;

class Cleaner
{
	public static function getUri($str, $replace=array("'"), $delimiter='-')
	{
		if( !empty($replace) )
		{
			$str = str_replace($replace, ' ', $str);
		}
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		do {
			$exist = false;
			if(substr($clean,0,1) == '-')
			{
				$clean = substr($clean,1);
				$exist = true;
			}
			if(substr($clean,strlen($clean)-1, 1) == '-')
			{
				$clean = substr($clean,0,-1);
				$exist = true;
			}
		} while ($exist != false);
		return $clean;
	}
}
?>