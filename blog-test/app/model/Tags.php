<?php


namespace model;

use \core\Mysql as sql;

class Tags {
	
	
	public function syncTags($tags, $article) {
		
		$tagsId = $this->defineTags($tags);
		$this->removeRelation($article);
		$this->createRelation($tagsId, $article);
	}
	
	protected function defineTags($tagsStr) {
		
		$tags = explode(' ', $tagsStr);
		$existingTags = [];
		
		foreach ($tags as $tag) {
			
			$id = $this->findTag($tag);
			if (!$id) {
				$id = $this->createTag($tag);
			}
			$existingTags[] = $id;
		}
		
		return $existingTags;
	}
	
	protected function findTag($tag) {
		
		$res = sql::db_query('SELECT id FROM tags WHERE name = :name', [':name' => $tag]);
		return sql::db_fetchAssoc($res)['id'];
	}
	
	protected function createTag($tag) {
		
		sql::db_query('INSERT INTO tags (name) VALUES (:name)', [':name' => $tag]);
		return sql::db_lastID();
	}
	
	protected function removeRelation($article) {
		
		sql::db_query('DELETE FROM tags_relations WHERE id_article = (:id)', [':id' => $article]);
	}
	
	protected function createRelation($tagsId, $article) {
		
		array_walk($tagsId, function (&$item) use ($article) {
			$item = "($item, $article)";
		});
		sql::db_query('INSERT INTO tags_relations (id_tag, id_article) VALUES ' . implode(',', $tagsId));
	}
	
}
