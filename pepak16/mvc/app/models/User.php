<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/pepak16/mvc/app/core/Database.php';

class User extends Database {
	
	protected $dbConnection;

	protected $userid;
	protected $username;
	protected $password;
	protected $phonenumber;
	protected $email;
	protected $zipcode;
	protected $post;

	// public function __construct($userid,$username,$password,$phonenumber,$email,$zipcode,$post) { 
	// 	$this->userid = $userid;
	// 	$this->username = $username;
	// 	$this->password = $password;
	// 	$this->phonenumber = $phonenumber;
	// 	$this->email = $email;
	// 	$this->zipcode = $zipcode;
	// 	$this->post = $post;
	// }

	public function __construct() {
		
	}

	public function getUserid() {
		return $this->userid;
	}

	public function setUserid($userid) {
		$this->userid;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password;
	}

	public function getPhonenumber() {
		return $this->phonenumber;
	}

	public function setPhonenumber($phonenumber) {
		$this->phonenumber;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email;
	}

	public function getZipcode() {
		return $this->zipcode;
	}

	public function setZipcode($zipcode) {
		$this->zipcode;
	}

	public function getPost() {
		return $this->post;
	}

	public function setPost($post) {
		$this->post;
	}

	public function authentificate($username,$password) {
		$this->dbConnection = new Database();
		// $this->dbConnection = new Database();
        $sql = 'SELECT user_id FROM user WHERE user_name = :domain_name AND user_password = :domain_pass';
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
        $stmt->bindParam(':domain_name', $username);
        $stmt->bindParam(':domain_pass', $password);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result[0];
        // if ($result[0] == NULL) {
        //     return false;
        // } else {
        //     return true;
        // }
	}

	public function fetchAllPosts() {
		$this->dbConnection = new Database();
		$sql = 'SELECT * FROM user_post ORDER BY user_post_time DESC';
		$pdo = $this->dbConnection->getConn();
		$data = $pdo->query($sql);
		$result = $data->fetchAll();
		return $result;
	}

	public function fetchUserPosts($userid) {
		$this->dbConnection = new Database();
		$sql = 'SELECT * FROM user_post WHERE post_by = :post_by ORDER BY user_post_time DESC';
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':post_by', $userid);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_NUM);
		return $result;
	}








	function insertUser($un, $pw, $pn, $em, $zc) {
		$this->dbConnection = new Database();
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
	
	function insertPost($hd,$dc,$url, $postedbyid) {
		$this->dbConnection = new Database();
		$sql = "INSERT INTO user_post (user_post_time, user_post_header, user_post_description, user_post_url, post_by) VALUES (now(), :domain_header, :domain_desc, :domain_url, :postbyid)";
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
		//$stmt->bindParam(':domain_id', uniqid());
		$stmt->bindParam(':domain_header', $hd);
		$stmt->bindParam(':domain_desc', $dc);
		$stmt->bindParam(':domain_url', $url);
		$stmt->bindParam(':postbyid', $postedbyid);
		$stmt->execute();
		$count = $stmt->rowCount();

		if ($count == 1) {
			return true;
		} else {
			return false;
		}
          
	}

	function getUsers() {
		$this->dbConnection = new Database();
		$sql = "SELECT user_id ,user_name, user_phonenumber, user_email, user_zipcode FROM user";
		$pdo = $this->dbConnection->getConn();
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$userTableArray = $stmt->fetchAll(PDO::FETCH_NUM);
		return $userTableArray;
	}

}

// $test = new User();

// $array = $test->fetchUserPosts(1);
// foreach ($array as $a) {
// 	echo $a[1];
// }