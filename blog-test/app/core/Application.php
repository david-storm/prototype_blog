<?php

namespace core;

class Application {
	
	const PATH_TEMPLATES = '..' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
	protected $routes = [];
	protected $arguments = [];
	
	public function __construct() {
		session_start();
		$this->routes = \BaseRoute::main();
	}
	
	public function request($urlWithParam) {
		
		$urlWithParam = explode('?', $urlWithParam);
		$url = $urlWithParam[0];
		$param = count($urlWithParam) > 1 ? $urlWithParam[1] : [];
		
		[$controller, $method] = explode('::', $this->searchRoute($url));
		
		$controllerPath = 'controller\\' . $controller;
		if (!class_exists($controllerPath)) {
			$this->error();
		}
		
		$loadedController = new $controllerPath;
		
		if(!method_exists($loadedController, $method)){
			$this->error();
		}
		
		if(!empty($_POST)){
			array_push($this->arguments, $_POST);
		}
		
		$result = call_user_func_array([$loadedController, $method], $this->arguments);
		
		return $result;
	}
	
	public function render($data){
		$content = '';
		
		if(isset($data['template'])){
			$template = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $data['template']);
			$templatePath = self::PATH_TEMPLATES . $template . '.php';
			unset($data['template']);
			
			if(!file_exists($templatePath)){
				$this->error(501, 'Something happened, please try again later');
			}
			ob_start();
			include $templatePath;
			$content = ob_get_clean();
			
		} elseif(is_array($data)){
			header('Content-Type: application/json');
			echo json_encode($data);
			die();
			
		} else {
			$content = $data;
		}
		$messages = $this->renderMessage();
		
		include self::PATH_TEMPLATES . 'layout.php';
	}
	
	protected function searchRoute($url){
		$replace = \BaseRoute::pregReplace();
		foreach ($this->routes as $route => $controller){
			$route = preg_replace(array_keys($replace), array_values($replace), $route);
			if(preg_match("#^$route$#", $url, $matches)){
				array_shift($matches);
				$this->arguments = $matches;
				return $controller;
			}
		}
		$this->error();
		return false;
	}
	
	protected function renderMessage(){
		if(empty($_SESSION['message'])){
			return '';
		}
		$content = '<div class="region-message">';
		foreach ($_SESSION['message'] as $message){
			$text = $message['text'];
			$status = $message['status'];
			$content .= "<div class=\"message $status\">$text</div>";
		}
		$content .= '</div>';
		unset($_SESSION['message']);
		
		return $content;
	}
	
	static public function getMessage($text, $status = 'success'){
		$_SESSION['message'][] = ['text' => $text, 'status' => $status];
	}
	
	static public function redirect($url, $statusCode = 301){
		header("Location: $url", TRUE, $statusCode);
		exit;
	}
	
	static public function error($status = 404, $message = 'Page not found'){
		http_response_code($status);
		echo $message;
		die();
	}
}