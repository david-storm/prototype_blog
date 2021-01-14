<?php


namespace validator;

use core\Messenger;

class ArticleValidator {
	
	protected static $arrayStatus = ['new', 'open', 'closed'];
	
	public static function validation(array &$data) {
		
		$result = TRUE;
		
		foreach ($data as &$datum){
			$datum = trim($datum);
		}
		
		if (empty($data['title'])) {
			
			Messenger::add('Empty title', 'error');
			$result = FALSE;
		}
		
		if (empty($data['content'])) {
			
			Messenger::add('Empty content', 'error');
			$result = FALSE;
		} else if(mb_strlen($data['content']) < 30 ){
			
			Messenger::add('Content must be longer than 30 charts', 'error');
			$result = FALSE;
		}
		
		if (empty($data['status'])){
			
			Messenger::add('Empty status', 'error');
			$result = FALSE;
		} else if (!in_array($data['status'], self::$arrayStatus)){
			
			Messenger::add('Wrong status', 'error');
			$result = FALSE;
		}
		
		return $result;
	}
	
}
