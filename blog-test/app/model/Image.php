<?php

namespace model;

use core\Application;
use \core\ModelCRUD as model;
use core\Mysql as sql;

class Image {
	
	private $uploadDir = 'storage' ;
	
	
	public function create($index) {
		
		$name = basename($_FILES['image']['name']);
		$filePath = $this->uploadDir . DIRECTORY_SEPARATOR. $name;
		
		if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
			Application::getMessage('Image not load', 'error');
			return FALSE;
		}
		
		sql::db_query('INSERT INTO `images` (`name`, `id_comment`)
			VALUES (:name, :index)',
			[':name' => $name, ':index' => $index]);
		
		return sql::db_lastID();
	}
	
	public function get($index) {
		$result = sql::db_query('SELECT `name` FROM images WHERE `id_comment` = :id', [':id' => $index]);
		$images = [];
		while ( $row =  sql::db_fetchAssoc($result)){
			$row['src'] = '/' . $this->uploadDir . '/' . $row['name'];
			$images[] = $row;
		}
		return $images;
	}
}