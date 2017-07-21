<?php

function dbconnect(){

require('../asdfghj.php');

	$server   = $dsn['server'];
	$user     = $dsn['user'];
	$pass     = $dsn['pass'];
	$database = $dsn['database'];

	//-------------------
	//DBに接続
	//-------------------
	try {
		$pdo = new PDO("mysql:dbname=$database;host=$server","$user","$pass",
		array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"));
				} catch (PDOException $e) {
			die($e->getMessage());
		}
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  // 静的プレースホルダを指定
	return $pdo;
}

?>