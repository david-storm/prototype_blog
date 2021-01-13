<?php


namespace core;

use core\Router;
use core\Messenger;


class Application {
	
	const PATH_TEMPLATES = '..' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
	protected $router;
	
	public function __construct() {
		session_start();
		$this->router = new Router();
	}
	
	public function request($url) {
		
		[$route, $arguments] = $this->router->searchRoute($url);
		[$controller, $method] = explode('::', $route);
		
		$controllerPath = 'controller\\' . $controller;
		if (!class_exists($controllerPath)) {
			$this->error();
		}
		
		$loadedController = new $controllerPath;
		if (!method_exists($loadedController, $method)) {
			$this->error();
		}
		
		if (!empty($_POST)) {
			array_push($arguments, $_POST);
		}
		
		return call_user_func_array([$loadedController, $method], $arguments);
	}
	
	public function render($data) {
		
		/* can be used for API, returns json */
		if (empty($data['template']) && is_array($data)) {
			
			header('Content-Type: application/json');
			array_push($data, Messenger::getArray());
			echo json_encode($data);
			exit(0);
		}
		
		/* can bu used render with template */
		if (!isset($data['template'])) {
			
			$content = $data;
		} else {
			
			$template = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $data['template']);
			$templatePath = self::PATH_TEMPLATES . $template . '.php';
			unset($data['template']);
			
			if (!file_exists($templatePath)) {
				$this->error(501, 'Something happened, please try again later');
			}
			ob_start();
			require_once $templatePath;
			$content = ob_get_clean();
		}
		
		$messages = Messenger::render();
		
		require_once self::PATH_TEMPLATES . 'layout.php';
	}
	
	static public function error(int $status = 404, string $message = 'Page not found') {
		
		http_response_code($status);
		echo $message;
		die();
	}
	
}
