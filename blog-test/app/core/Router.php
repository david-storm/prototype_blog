<?php


namespace core;

use core\Application;


class Router {
	
	protected $routes;
	protected $argumentsInRoutes = ['#%id#' => '([0-9]+)', '#%id?#' => '([0-9]*?)'];
	
	public function __construct() {
		
		$this->routes = require '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'routes.php';
	}
	
	public function searchRoute($url) {
		
		$replace = $this->argumentsInRoutes;
		
		foreach ($this->routes as $route => $controller) {
			
			$routeNew = preg_replace(array_keys($replace), array_values($replace), $route);
			
			if (preg_match("#^$routeNew$#", $url, $matches)) {
				array_shift($matches);
				return [$controller, $matches];
			}
		}
		Application::error();
		return false;
	}
	
	public static function redirect(string $url, int $statusCode = 301) {
		
		header("Location: $url", TRUE, $statusCode);
		exit;
	}
	
}
