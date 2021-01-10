<?php

require_once '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$app = new \core\Application();
$response = $app->request($url);
$app->render($response);