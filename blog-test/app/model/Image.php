<?php


namespace model;

use core\Messenger;
use core\Mysql as sql;


class Image {
	
	protected $uploadDir = 'storage' ;
	
	public function create($index) {
		
		for ($i = 0; $i < count($_FILES['image']['name']); $i++){
			$name = basename($_FILES['image']['name'][$i]);
			$filePath = $this->uploadDir . DIRECTORY_SEPARATOR. $name;
			
			if (!move_uploaded_file($_FILES['image']['tmp_name'][$i], $filePath)) {
				Messenger::add("Image $name not load", 'error');
				continue;
			}
			
			sql::db_query('INSERT INTO `images` (`name`, `id_comment`)
			VALUES (:name, :index)',
				[':name' => $name, ':index' => $index]);
			
		}
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
