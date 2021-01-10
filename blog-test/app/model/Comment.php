<?php

namespace model;

use \core\ModelCRUD as model;
use core\Mysql as sql;

class Comment {
	
	public function create($data) {
		sql::db_query('INSERT INTO `comments` (`email`, `content`, `id_article`)
			VALUES (:email, :content, :id)',
			[':email' => $data['email'], ':content' => $data['content'], ':id' => $data['id']]);
		
		return sql::db_lastID();
	}
	
	public function get($index) {
		$result = sql::db_query('SELECT `email`, `content`, `id` FROM comments WHERE `id_article` = :id', [':id' => $index]);
		$comments = [];
		while ( $row =  sql::db_fetchAssoc($result)){
			$row['images'] = (new Image())->get($row['id']);
			$comments[] = $row;
		}
		return $comments;
	}
}