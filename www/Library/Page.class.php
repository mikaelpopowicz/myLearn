<?php
namespace Library;
 
class Page extends ApplicationComponent
{
	protected $contentFile;
	protected $vars = array();

   
	public function addVar($var, $value)
	{
		if (!is_string($var) || is_numeric($var) || empty($var))
		{
			throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractère non nulle');
		}
     
		$this->vars[$var] = $value;
	}
	
	public function getVars() { return $this->vars; }
	
	public function updateVar($var, $value)
	{
		if (is_array($this->vars[$var])) {
			array_push($this->vars[$var], $value);
		}
	}
   
	public function getGeneratedPage()
	{
		if (!file_exists($this->contentFile))
		{
			throw new \RuntimeException('La vue spécifiée n\'existe pas');
		}
		// Ajout variable globale
		$config = $this->app->config();
		$user = $this->app->user();
		if($this->app->name() == "Frontend") $classes = $user->getAttribute('classes');
		
		// Extraction de variable du controlleur
		extract($this->vars);
		
		// Début de la tamporisation
		ob_start();
		require $this->contentFile;
		$content = ob_get_clean();
		ob_start();
		
		// Calcul du temps d'execution
		$this->app->loading()->setEnd(microtime(true));
		$load = $this->app->loading();
		
		// Ajout du template
		if(!isset($no_layout) || !$no_layout)
		{
			require __DIR__.'/../Applications/'.$this->app->name().'/Templates/layout.php';
		}
		else
		{
			require __DIR__.'/../Applications/'.$this->app->name().'/Templates/nolayout.php';
		}
		return ob_get_clean();
	}
   
	public function setContentFile($contentFile)
	{
		if (!is_string($contentFile) || empty($contentFile))
		{
			throw new \InvalidArgumentException('La vue spécifiée est invalide');
		}
     
		$this->contentFile = $contentFile;
	}
}