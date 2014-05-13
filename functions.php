<?php
require_once('config.php');
require_once('connect.php');

function query($query) {
		$args = func_get_args();
		if(!isset($args[1])) return mysql_query($query);
		array_shift($args);
		foreach($args as &$a) $a = mysql_real_escape_string($a);
		return mysql_query(vsprintf($query, $args));	
	}
	
function in_database($userEmail){
	query("SELECT * FROM testUsers WHERE User_email='%s'", $userEmail);
	return mysql_affected_rows();
}
	
function addUser($email, $pass){
	//verify email and password length
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Error: Invalid E-mail Address.";
	if(strlen($pass)<8) return "Error: Password Too Short.";

	if(in_database($email)) return 'Error: Email Already In Use.';
	require 'PasswordHash.php';
	$hasher = new PasswordHash(8, FALSE);

	return query("INSERT INTO testUsers (User_email, User_Password, User_RegDate, User_LastLogin, User_LoginIP, User_Agent) VALUES('%s', '%s', '%s', '%s', '%s', '%s')", $email, $hasher->HashPassword($pass), date('c'), date('c'), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'])?'Success':'Failed';
}
?>