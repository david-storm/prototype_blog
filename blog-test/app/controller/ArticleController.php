<?php

namespace controller;

use core\Auth;
use core\Messenger;
use core\Router;
use model\Article;
use model\Comment;
use model\Tags;
use validator\ArticleValidator;


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
		
		$action = ['action' => 'admin/create', 'operation' => 'Create'];
		
		if (empty($data)) {
			return ['template' => 'admin/create'] + $action;
		}
		
		if (!ArticleValidator::validation($data)) {
			return ['template' => 'admin/create', 'article' => $data] + $action;
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
		return '';
	}
	
	public function edit($index, $data = []) {
		
		$action = ['action' => 'admin/edit/' . $index, 'operation' => 'Update'];
		
		if (empty($data)) {
			
			$article = (new Article())->get($index);
			$article['id'] = $index;
			return ['template' => 'admin/create', 'article' => $article] + $action;
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
			Messenger::add('Article success update');
		} else {
			Messenger::add('Error, try again', 'error');
		}
		
		Router::redirect('/admin');
		return '';
	}
	
	public function delete($index) {
		
		$res = (new Article())->delete($index);
		(new Tags())->syncTags([], $index);
		
		if ($res) {
			Messenger::add('article success deleted');
		} else {
			Messenger::add('Error, try again', 'error');
		}
		
		Router::redirect('/admin');
	}
	
}
