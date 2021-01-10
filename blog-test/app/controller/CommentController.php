<?php

namespace controller;

use core\Application;

class CommentController {
	
	protected $comment;
	protected $image;
	
	public function __construct() {
		$this->comment = new \model\Comment();
		$this->image = new \model\Image();
	}
	
	public function add($aid, $data) {
		
		if($this->valid($data)){
			if($id_comment = $this->comment->create($data + ['id' => $aid])){
				$this->image->create($id_comment);
				Application::getMessage('New comment added');
			}
		}
		
		Application::redirect('/article/' . $aid);
	}
	
	protected function valid(&$data) {
		
		if(empty($data['email']) || empty($data['content']) ){
			Application::getMessage('empty filed', 'error');
			return false;
		}
		foreach ($data as $key => &$value){
			$value = trim($value);
			$value = htmlspecialchars($value);
		}
		
		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
			Application::getMessage('E-mail not valid', 'error');
			return false;
		}
		
		if(mb_strlen($data['content']) < 20){
			Application::getMessage('Content must be longer than 20 characters', 'error');
			return false;
		}
		
		return true;
	}
}