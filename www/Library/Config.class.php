<?php
namespace Library;
 
class Config extends ApplicationComponent
{
	protected $vars = array();
   
	public function get($var)
	{
		if (!$this->vars)
		{
			$xml = new \DOMDocument;
			$xml->load(__DIR__.'/../Applications/'.$this->app->name().'/Config/app.xml');
       
			$elements = $xml->getElementsByTagName('define');
       
			foreach ($elements as $element)
			{
				$this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
			}
		}
     
		if (isset($this->vars[$var]))
		{
			if(substr($var,0,2) == "db" || substr($var,0,4) == "smtp")
			{
				foreach ($this->vars as $key => $value) {
					if($key == "cryp_key")
					{
						return $this->app->key()->decode($this->vars[$var],$value);
					}
				}
			}
			return $this->vars[$var];
		}
     
		return null;
	}
	
	public function setVar($var,$value)
	{
		$this->vars[$var] = $value;
	}
	
	public function save()
	{
		$xml = '<?xml version="1.0" encoding="utf-8" ?>
<definitions>';
		if(is_array($this->vars) && !empty($this->vars))
		{
			foreach ($this->vars as $var => $value)
			{
				$xml .= '
	<define var="'.$var.'" value="'.$value.'" />';
			}
		}
		$xml .= '
</definitions>';
		$paths = array('Admin','Frontend','Json','Prof');
		$erreurs = array();
		foreach ($paths as $path) {
			$file = fopen('../Applications/'.$path.'/Config/app.xml', 'w+');
			ftruncate($file,0);
			$write = fwrite($file,$xml);
			fclose($file);
			if(!$write)
			{
				$erreurs[] = $path;
			}
		}
		return array($xml,$erreurs);
	}
}