<?php

namespace controller;

use core\Auth;
use core\Application;
use model\Article;
use model\Comment;
use model\Tags;

class ArticleController {
	
	protected $article;
	protected $tag;
	
	public function __construct() {
		$this->article = new Article();
		$this->tag = new Tags();
	}
	
	public function front() {
		$articles = $this->article->viewAll();
		return ['template' => 'main', 'articles' => $articles];
	}
	
	public function page($index) {
		$article = $this->article->get($index);
		$comments = (new Comment())->get($index);
		$article['tags'] = str_replace(',', ' ',  $article['tags']);
		return ['template' => 'page', 'article' => $article, 'comments' => $comments];
	}
	
	public function admin() {
		
		$auth = new Auth();
		if ($auth->isAdmin() === false) {
			$auth->authenticate();
		}
		$articles = $this->article->viewAll(50, TRUE);
		
		return ['template' => 'admin/main', 'articles' => $articles];
	}
	
	public function create($data = []) {
		
		if (empty($data)) {
			return ['template' => 'admin/create'];
		}
		
		$index = $this->article->create($data);
		$this->tag->syncTags($data['tags'], $index);
		
		if ($index > 0) {
			Application::getMessage('article success created');
		} else {
			Application::getMessage('Error, try again', 'error');
		}
		
		Application::redirect('/admin');
	}
	
	public function edit($index, $data = []) {
		
		if (empty($data)) {
			$article = $this->article->get($index);
			$article['id'] = $index;
			return ['template' => 'admin/edit', 'article' => $article];
		}
		
		$res = TRUE;
		
		$article = $this->article->get($index);
		if($article['title'] !== $data['title'] ||
			$article['content'] !== $data['content'] ||
			$article['status'] !== $data['status']) {
			$res = $this->article->update($index, $data);
		}
		
		if ($article['tags'] !== $data['tags']) {
			$this->tag->syncTags($data['tags'], $index);
		}
		
		if ($res) {
			Application::getMessage('article success update');
		} else {
			Application::getMessage('Error, try again', 'error');
		}
		
		Application::redirect('/admin');
	}
	
	public function delete($index) {
		
		$res = $this->article->delete($index);
		
		if ($res) {
			Application::getMessage('article success deleted');
		} else {
			Application::getMessage('Error, try again', 'error');
		}
		
		Application::redirect('/admin');
	}
	
}