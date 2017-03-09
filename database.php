<?php
require_once('config/constant.php');
class DatabaseFunction {

	private $conn;

	public function __construct() {
		$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DB);
		
	}
}
?>