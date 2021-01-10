<?php

const SRC_DIR = __DIR__ . DIRECTORY_SEPARATOR .'app' . DIRECTORY_SEPARATOR;

spl_autoload_register(function ($class) {
	include SRC_DIR .  str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
});

$url = $_SERVER["REQUEST_URI"];