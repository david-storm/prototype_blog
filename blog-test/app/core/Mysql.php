<?php

namespace core;

use PDO;
use PDOStatement;

class Mysql
{
	/** @var $link PDO */
	private static $link;
	const CONFIG_DB = '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .'constantDB.php';
	
	private static function connect() {
		require self::CONFIG_DB;
		self::$link = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
	}
	
	public static function db_query($sql, $param = []) {
		
		if (!self::$link) {
			self::connect();
		}
		$query = self::$link->prepare($sql);
		$query->execute($param);
		return $query;
	}
	
	public static function db_fetchAssoc(PDOStatement $res) {
		return $res->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function db_rowCount(PDOStatement $res){
		return $res->rowCount();
	}
	
	public static function db_lastID($name = null) {
		if (self::$link) {
			return self::$link->lastInsertId($name);
		}
		return -1;
	}
	
	public static function db_escapeString($string) {
		if (!self::$link) {
			self::connect();
		}
		return self::$link->quote($string);
	}
	
	public static function db_error() {
		if (self::$link){
			return self::$link->errorInfo() ;
		}
		return "";
	}
	
	public static function close() {
		self::$link = NULL;
	}
	
}