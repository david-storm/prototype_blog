<?php

spl_autoload_register(function ($class) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR .
		str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
});
