<?php

namespace controller;

use core\Auth;
use core\Application;
use core\Messenger;
use core\Router;
use model\Article;
use model\Comment;
use model\Tags;

class ArticleController {
	
	public function front() {
		
		$articles = (new Article())->viewAll();
		return ['template' => 'main', 'articles' => $articles];
	}
	
	public function page(int $index) {
		
		$article = (new Article())->get($index);
		$comments = (new Comment())->get($index);
		
		return ['template' => 'page', 'article' => $article, 'comments' => $comments];
	}
	
	public function admin() {
		
		$auth = new Auth();
		if ($auth->isAdmin() === false) {
			
			$auth->authenticate();
		}
		$articles = (new Article())->viewAll(50, TRUE);
		
		return ['template' => 'admin/main', 'articles' => $articles];
	}
	
	public function create(array $data = []) {
		
		if (empty($data)) {
			
			return ['template' => 'admin/create'];
		}
		
		$article = new Article();
		
		
		$index = $article->create($data);
		
		if ($index > 0) {
			(new Tags())->syncTags($data['tags'], $index);
			Messenger::add('article success created');
		} else {
			Messenger::add('Error, try again', 'error');
		}
		
		Router::redirect('/admin');
	}
	
	public function edit($index, $data = []) {
		
		if (empty($data)) {
			$article = (new Article())->get($index);
			$article['id'] = $index;
			return ['template' => 'admin/edit', 'article' => $article];
		}
		
		$res = TRUE;
		
		$article = (new Article())->get($index);
		
		if ($article['title'] !== $data['title'] ||
			$article['content'] !== $data['content'] ||
			$article['status'] !== $data['status']) {
			
			$res = (new Article())->update($index, $data);
		}
		
		if ($article['tags'] !== $data['tags']) {
			(new Tags())->syncTags($data['tags'], $index);
		}
		
		if ($res) {
			Application::add('article success update');
		} else {
			Application::add('Error, try again', 'error');
		}
		
		Application::redirect('/admin');
	}
	
	public function delete($index) {
		
		$res = (new Article())->delete($index);
		
		if ($res) {
			Application::getMessage('article success deleted');
		} else {
			Application::getMessage('Error, try again', 'error');
		}
		
		Application::redirect('/admin');
	}
	
//	protected function end
	
}