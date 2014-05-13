<?php
require_once('session.php');

switch ($_POST['action']) {
    case 'signUp':
        echo addUser($_POST['email'], $_POST['pass']);
        break;
        
    case 'login':
        $sessionUser->login($_POST['email'], $_POST['pass'], $_POST['rem']);
        break;
        
    case 'logout':
        $sessionUser->logout();
        break;
        
    default:
       echo "Error: Invalid Action!";
}