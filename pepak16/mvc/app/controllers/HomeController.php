<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/pepak16/mvc/app/core/Controller.php';
class HomeController extends Controller {
	
	public function index () {
		//This is a proof of concept - we do NOT want HTML in the controllers!
		//echo '<br><br>Home Controller Index Method<br>';
		// echo 'Param: ' . $param . '<br><br>';
		//header('Location: app/views/index.php');
	}
	
	public function other ($param1 = 'first parameter', $param2 = 'second parameter') {
		$user = $this->model('User');
		$user->name = $param1;
		$viewbag['username'] = $user->name;
		$this->view('home/index', $viewbag);
	}
	
	public function restricted () {
		echo 'Welcome - you must be logged in';
	}
	
	public function login($username,$password) {
		require 'db_connect.php';
        if (authentificateUser($username,$password)) {
			$_SESSION['logged_in'] = true;
			$this->view('home/login');
        }
	}
	
	public function logout() {
		
		if($this->post()) {
			session_unset();
			header('Location: /mvc/public/home/loggedout');
		} else {
			echo 'You can only log out with a post method';
		}
	}
	
	public function loggedout() {
		echo 'You are now logged out';
	}

	public function changeMenuOptionTo($name) {
		switch ($name) {
			case "home":
				header('Location: /pepak16/mvc/public');
				break;
			case "login":
				header('Location: /pepak16/mvc/app/views/home/login.php');
				break;
			case "register":
				header('Location: /pepak16/mvc/app/views/home/register.php');
				break;
			case "logout":
				header('Location: /pepak16/mvc/app/views/home/loggedout.php');
				break;
			default:
				break;
		}
	}
	
}