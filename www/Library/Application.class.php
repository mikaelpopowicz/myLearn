<?php
namespace Library;
 
abstract class Application
{
	protected $httpRequest;
	protected $httpResponse;
	protected $name;
	protected $user;
	protected $config;
	protected $key;
	protected $mail;
	protected $message;
	protected $loading;
	public function __construct($name = "", $start)
	{
		$this->name			= $name;
		$this->httpRequest	= new HTTPRequest($this);
		$this->httpResponse	= new HTTPResponse($this);
		$this->user			= new User($this);
		$this->config		= new Config($this);
		$this->key			= new Keygen($this);
		$this->message		= new Message($this);
		$this->loading		= new Loading($start);
		setlocale(LC_ALL, 'en_US.UTF8');
	}
   
	public function getController()
	{
		$router = new \Library\Router;
		$xml = new \DOMDocument;
		$xml->load(__DIR__.'/../Applications/'.$this->name.'/Config/routes.xml');
		$routes = $xml->getElementsByTagName('route');
     
		// On parcourt les routes du fichier XML.
		foreach ($routes as $route)
		{
			$vars = array();
       
			// On regarde si des variables sont présentes dans l'URL.
			if ($route->hasAttribute('vars'))
			{
				$vars = explode(',', $route->getAttribute('vars'));
			}
       
			// On ajoute la route au routeur.
			
			$router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
		}
		
		try
		{
			// On récupère la route correspondante à l'URL.
			$matchedRoute = $router->getRoute($this->httpRequest->requestURI());
		}
		catch (\RuntimeException $e)
		{
			if ($e->getCode() == \Library\Router::NO_ROUTE)
			{
				// Si aucune route ne correspond, c'est que la page demandée n'existe pas.
				if ($this->user->isAuthenticated()) {
					$this->httpResponse->redirect404(new \Library\Page($this));
				} else {
					return false;
				}
			}
		}
     
		// On ajoute les variables de l'URL au tableau $_GET.
		$_GET = array_merge($_GET, $matchedRoute->vars());
     
		// On instancie le contrôleur.
		$controllerClass = 'Applications\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
		return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
	}
   
	abstract public function run();
   
	public function httpRequest()
	{
		return $this->httpRequest;
	}
   
	public function httpResponse()
	{
		return $this->httpResponse;
	}
   
	public function name()
	{
		return $this->name;
	}
	
	public function config() {
		return $this->config;
	}
	
	public function user() {
		return $this->user;
	}
	
	public function key() {
		return $this->key;
	}

	public function mail() {
		return $this->mail;
	}
	
	public function message() {
		return $this->message;
	}
	
	public function loading() {
		return $this->loading;
	}
}