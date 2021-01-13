<?php


namespace core;


class Messenger {
	
	static public function add(string $text, string $status = 'success') {
		
		array_push($_SESSION['messages'], ['text' => $text, 'status' => $status]);
	}
	
	static public function render() {
		
		if (empty($_SESSION['messages'])) {
			return '';
		}
		
		$content = '<div class="region-message">';
		$content .= array_reduce($_SESSION['messages'], function ($message) {
			return '<div class="message ' . $message['status'] . '">' . $message['text'] . '</div>';
		});
		$content .= '</div>';
		
		unset($_SESSION['messages']);
		
		return $content;
	}
	
	static public function getArray() {
		
		if (empty($_SESSION['messages'])) {
			return [];
		}
		
		$messages = $_SESSION['messages'];
		unset($_SESSION['messages']);
		
		return $messages;
	}
	
}
