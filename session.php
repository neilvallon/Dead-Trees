<?php
require_once('functions.php');
$sessionUser = new sessionManager;

class sessionManager{
	public $logedin, $email, $pass, $rem, $IP, $userAgent, $UID;
	
	function __construct(){
		$this->IP = $_SERVER['REMOTE_ADDR'];
		$this->userAgent = $_SERVER['HTTP_USER_AGENT'];
		$this->logedin = $this->isLoggedIn();
		if($this->logedin)$this->UID = $_SESSION['userid'];
	}
	
	function isLoggedIn(){
		session_start();
		return (isset($_SESSION['valid']) && $_SESSION['valid'] && $_SESSION['agent'] == md5($this->userAgent))? $this->swapID() : $this->logout();
	}
	
	function logout(){
		unset($_SESSION);
		session_destroy();
		session_start();
		$this->logedin = false;
	}
	
	function validateSession(){
		session_regenerate_id();
		$_SESSION['valid'] = 1;
		$_SESSION['lastRegeneration'] = 0;
		$_SESSION['userid'] = $this->UID;
		$_SESSION['agent'] = md5($this->userAgent);
		$this->logedin = true;
		return "You Should be loged in now.";
	}
	
	function swapID(){
	if(++$_SESSION['lastRegeneration'] > 5){ //Swaps session every 5 checks
		$_SESSION['lastRegeneration'] = 0;
		session_regenerate_id();
		echo "swaped";
	}
	return true;
	}
	
	
	function login(){
		require 'PasswordHash.php';
		$hasher = new PasswordHash(8, FALSE);
		$result = query("SELECT * FROM testUsers WHERE User_email='%s'", $this->email);
		$result = mysql_fetch_array($result, MYSQL_ASSOC);
		if(mysql_affected_rows()){
			query("UPDATE testUsers SET User_LastLogin='%s', User_LoginIP='%s', User_Agent='%s' WHERE User_email='%s'", date('c'), $this->IP, $this->userAgent, $this->email);
		}else{
			return 'Error: User Does Not Exist.';
		}
		$this->UID = $result['UID'];
		return ($hasher->CheckPassword($this->pass, $result['User_Password']))?$this->validateSession():'Error: Password Incorect';
	}
}
?>