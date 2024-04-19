<?php
class DatabaseConnection {

const DB_USER = 'root';
const DB_NAME = 'plants';
const DB_PASSWORD = '';
const DB_HOST = 'localhost';

public $pdo;

function __construct() {
	try {
		$dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";
		$this->pdo = new PDO($dsn, self::DB_USER, self::DB_PASSWORD);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) 
    {
		die('Could not connect to MySQL: ' . $e->getMessage());
	}
}
}
global $db;
$db = new DatabaseConnection();