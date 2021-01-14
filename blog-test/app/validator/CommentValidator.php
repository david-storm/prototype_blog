<?php


namespace validator;

use core\Messenger;

class CommentValidator {
	
	public static function validation(&$data){
		
		$result = TRUE;
		
		foreach ($data as &$value) {
			$value = trim($value);
		}
		
		if (empty($data['email']) ){
			
			Messenger::add('Empty e-mail', 'error');
			$result = FALSE;
		} else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			
			Messenger::add('E-mail not valid', 'error');
			$result = FALSE;
		}
		
		if ( empty($data['content'])) {
			
			Messenger::add('Empty content', 'error');
			$result = FALSE;
		} else if (mb_strlen($data['content']) < 20) {
			
			Messenger::add('Content must be longer than 20 charts', 'error');
			$result = FALSE;
		}
		
		return $result;
	}
	
}
