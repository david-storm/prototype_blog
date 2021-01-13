<?php

return [
	
	'/' => 'ArticleController::front',
	'/article/%id' => 'ArticleController::page',
	'/admin' => 'ArticleController::admin',
	'/admin/create' => 'ArticleController::create',
	'/admin/delete/%id' => 'ArticleController::delete',
	'/admin/edit/%id' => 'ArticleController::edit',
	'/comment/%id' => 'CommentController::add',
	
];
