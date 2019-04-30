<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/pepak16/mvc/app/core/Database.php';

class User extends Database {
	
	protected $dbConnection;
	protected $username;
	protected $password;
	protected $post;

	public function __construct() { 
		$this->dbConnection = new Database();
	}

	public function authentificate($username,$password) {
		// $this->dbConnection = new Database();
        $sql = 'SELECT user_id FROM user WHERE user_name = :domain_name AND user_password = :domain_pass';
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
        $stmt->bindParam(':domain_name', $username);
        $stmt->bindParam(':domain_pass', $password);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        if ($result[0] == NULL) {
            return false;
        } else {
            return true;
        }
	}

	public function fetchPosts() {
		return true;
	}

}