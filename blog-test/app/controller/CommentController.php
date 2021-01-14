<?php


namespace controller;

use core\Messenger;
use core\Router;
use model\Comment;
use model\Image;
use validator\CommentValidator;


class CommentController {
	
	public function add($id, $data) {
		
		if (!CommentValidator::validation($data)) {
			Router::redirect('/article/' . $id);
		}
		
		if ($id_comment = (new Comment())->create($data + ['id' => $id])) {
			
			if (($_FILES['image']['error'] ?? 0) !== UPLOAD_ERR_NO_FILE) {
				(new Image())->create($id_comment);
			}
			Messenger::add('New comment added');
		}
		
		Router::redirect('/article/' . $id);
	}
	
}
