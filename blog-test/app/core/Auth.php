<?php

namespace core;

class Auth {
	
	protected $role;
	private $login = 'admin';
	private $password = '123456';
	
	public function __construct() {
		$this->role = $_SESSION['user']['role'] ?? false;
	}
	
	public function isAdmin($role = 'admin'){
		return (bool) $this->role === $role;
	}
	
	public function authenticate(){
		
		if($_SERVER['PHP_AUTH_USER'] ?? '' === $this->login && $_SERVER['PHP_AUTH_PW'] ?? '' === $this->password){
			$this->login = $_SESSION['user']['role'] = 'admin';
			return;
		}
		header('WWW-Authenticate: Basic realm="Admin blog"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Authentication required to access the admin page';
		exit;
	}
	
}