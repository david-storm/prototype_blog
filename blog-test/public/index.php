<?php

require_once '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$app = new core\Application();
$response = $app->request(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$app->render($response);
