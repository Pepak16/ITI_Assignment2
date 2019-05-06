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
		$sql = 'SELECT * FROM user_post ORDER BY user_post_time DESC';
		$pdo = $this->dbConnection->getConn();
		$data = $pdo->query($sql);
		$result = $data->fetchAll();
		return $result;
	}

	function insertUser($un, $pw, $pn, $em, $zc) {
		$sql = 'INSERT INTO user 
				SELECT * FROM (SELECT UUID(),:domain_name,:domain_pass,:domain_phone,:domain_email,:domain_zipcode) AS tmp
				WHERE NOT EXISTS (SELECT `user_name` FROM user WHERE `user_name` = :domain_name) LIMIT 1';
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':domain_name', $un);
		$stmt->bindParam(':domain_pass', $pw);
		$stmt->bindParam(':domain_phone', $pn);
		$stmt->bindParam(':domain_email', $em);
		$stmt->bindParam(':domain_zipcode', $zc);
		$stmt->execute();
		$count = $stmt->rowCount();

		if ($count == 1) {
			return true;
		} else {
			return false;
		}
		//return true;
	}
	
	function insertPost($hd,$dc,$url) {
		$sql = "INSERT INTO user_post VALUES (:domain_id, now(), :domain_header, :domain_desc, :domain_url)";
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':domain_id', uniqid());
		$stmt->bindParam(':domain_header', $hd);
		$stmt->bindParam(':domain_desc', $dc);
		$stmt->bindParam(':domain_url', $url);
		$stmt->execute();
		$count = $stmt->rowCount();

		if ($count == 1) {
			return true;
		} else {
			return false;
		}
          
	}

	function getUsers() {
		$sql = "SELECT user_name, user_phonenumber, user_email, user_zipcode FROM user";
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':domain_id', uniqid());
		$stmt->bindParam(':domain_header', $hd);
		$stmt->bindParam(':domain_desc', $dc);
		$stmt->bindParam(':domain_url', $url);
		$stmt->execute();
		$userTableArray = $stmt->fetchAll(PDO::FETCH_NUM);
		return $userTableArray;
	}

}

