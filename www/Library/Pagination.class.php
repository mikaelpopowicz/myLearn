<?php
namespace Library;

class Pagination
{	
	public static function getFrontThemePag(array $params)
	{
		// Récupération des variables
		$delta = $params['delta'];
		$number = $params['number'];
		$cur_page = $params['current'];
		$url = $params['url'];
		
		$pre = array(
			"class" => $cur_page == 1 ? " unavailable" : "",
			"uri" => $cur_page == 1 ? "" : " href='".$url."_".($cur_page-1)."'"
		);
		
		$sui = array(
			"class" => $cur_page == $number ? " unavailable" : "",
			"uri" => $cur_page == $number ? "" : " href='".$url."_".($cur_page+1)."'"
		);
		
		// Début de la chaine
		$str = "<div class='pagination-centered'>\n\t<ul class='pagination'>";
		$str .= "\n\t\t<li class='arrow".$pre['class']."'>\n\t\t\t<a".$pre['uri'].">«</a>\n\t\t</li>";
		
		
		if ($number <= 12)
		{
			
			
			for ($i=1; $i < $number+1; $i++) { 
				$current = $cur_page == $i ? " class='current'" : "";
				$uri = $cur_page == $i ? "" : " href='".$url."_".$i."'";
				$str .= "\n\t\t<li".$current.">\n\t\t\t<a".$uri.">".$i."</a>\n\t\t</li>";
			}
		}
		else
		{
			
		}
		
		
		// Fin de la chaine et retour
		$str .= "\n\t\t<li class='arrow".$sui['class']."'>\n\t\t\t<a".$sui['uri'].">»</a>\n\t\t</li>";
		$str .= "\n\t</ul>\n</div>";
		return $str;
	}
	
	public static function getB3Pag(array $params)
	{
		// Récupération des variables
		$delta = $params['delta'];
		$number = $params['number'];
		$cur_page = $params['current'];
		$url = $params['url'];
		
		$pre = array(
			"class" => $cur_page == 1 ? "disabled" : "",
			"uri" => $cur_page == 1 ? "" : " href='".$url."_".($cur_page-1)."'"
		);
		
		$sui = array(
			"class" => $cur_page == $number ? "disabled" : "",
			"uri" => $cur_page == $number ? "" : " href='".$url."_".($cur_page+1)."'"
		);
		
		// Début de la chaine
		$str = "<div class='text-center'>\n\t<ul class='pagination'>";
		$str .= "\n\t\t<li class='".$pre['class']."'>\n\t\t\t<a".$pre['uri'].">&laquo;</a>\n\t\t</li>";
		
		
		if ($number <= 12)
		{
			
			
			for ($i=1; $i < $number+1; $i++) { 
				$current = $cur_page == $i ? " class='active'" : "";
				$uri = $cur_page == $i ? "" : " href='".$url."_".$i."'";
				$str .= "\n\t\t<li".$current.">\n\t\t\t<a".$uri.">".$i."</a>\n\t\t</li>";
			}
		}
		else
		{
			
		}
		
		
		// Fin de la chaine et retour
		$str .= "\n\t\t<li class='".$sui['class']."'>\n\t\t\t<a".$sui['uri'].">&raquo;</a>\n\t\t</li>";
		$str .= "\n\t</ul>\n</div>";
		return $str;
	}
}
?>