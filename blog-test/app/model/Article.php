<?php
namespace model;
use \core\Mysql as sql;
use \core\ModelCRUD as model;

class Article implements model{
	
	public function viewAll($count = 20, $isAdmin = false){
		$filterStatus = $isAdmin ? '' : "WHERE a.`status` = 'open' OR a.`status` = 'new'";
		$result = sql::db_query(sprintf("SELECT a.`title`, a.`content`, a.`id`, a.`status`, a.`time_created`, GROUP_CONCAT(t.name SEPARATOR ' ') as tags
			FROM `article` a
			LEFT JOIN `tags_relations` r ON(r.id_article = a.id)
			LEFT JOIN `tags` t ON(t.id = r.id_tag)
			%s
			GROUP BY a.`id`
			ORDER BY a.`time_created` DESC
			LIMIT %d",$filterStatus, $count));
		$articles = [];
		while ($row = sql::db_fetchAssoc($result)) {
			$articles[] = $row;
		}
		
		return $articles;
	}
	
	public function create($data){
		$result = sql::db_query('INSERT INTO `article` (`title`, `content`, `status`, `time_created`)
			VALUES (:title, :content, :status, UNIX_TIMESTAMP())',
		[':title' => $data['title'], ':content' => $data['content'], ':status' => $data['status']]);
		
		return sql::db_lastID();
	}
	
	public function get($index){
		$result = sql::db_query('SELECT a.title, a.content, a.status, GROUP_CONCAT(t.name) as tags, a.id
			FROM article a
			LEFT JOIN tags_relations r ON(r.id_article = a.id)
			LEFT JOIN tags t ON(t.id = r.id_tag)
			WHERE a.id = :id
			GROUP BY a.id
			LIMIT 1', [':id' => $index]);
		
		return sql::db_fetchAssoc($result);
	}
	
	public function update($index, $data){
		$result = sql::db_query('UPDATE `article` SET `title` = :title, `content` = :content, `status` = :status
			WHERE `id` = :id', [':title' => $data['title'], ':content' => $data['content'],
			':status' => $data['status'], ':id' => $index]);
		
		return (bool) sql::db_rowCount($result);
	}
	
	public function delete($index){
		$result = sql::db_query('DELETE FROM `article`
			WHERE `id` = :id LIMIT 1', [':id' => $index]);
		
		return (bool) sql::db_rowCount($result);
	}
	
}