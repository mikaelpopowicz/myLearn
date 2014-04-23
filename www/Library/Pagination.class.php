<?php
namespace Library;

class Pagination
{	
	public static function toString(array $params)
	{
		// Récupération des variables
		$delta = $params['delta'];
		$number = $params['number'];
		$current = $params['current'];
		$url = $params['url'];
		
		// Début de la chaine
		$str = "<ul>";
		
		if ($number < 11)
		{
			for ($i=1; $i < $number+1; $i++) { 
				$cur = $current == $i ? " class='current'" : "";
				$uri = $current == $i ? "" : " href='".$url."_".$i."'";
				$str .= "\n\t<li".$cur.">\n\t\t<a".$uri.">".$i."</a>\n\t</li>";
			}
		}
		else
		{
			
		}
		
				
		// Fin de la chaine et retour
		$str .= "\n</ul>";
		return $str;
	}
}
?>