<?php
require_once('session.php');

switch ($_POST['action']) {
    case 'signUp':
        echo addUser($_POST['email'], $_POST['pass']);
        break;
    case 'login':
        $sessionUser->email = $_POST['email'];
        $sessionUser->pass = $_POST['pass'];
    	$sessionUser->rem =  false;
        echo $sessionUser->login();
        break;
    case 'logout':
        $sessionUser->logout();
        echo "You should be loged out now.";
        break;
    default:
       echo "Error: Invalid Action!";
}