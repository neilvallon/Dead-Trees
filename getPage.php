<?php
if(isset($_REQUEST['pageID'])){
switch($_REQUEST['pageID']){
    case 'signUp':
        require_once('templates/signUp.php');
        break;
    case 'login':
        require_once('templates/login.php');
        break;
}
}else{

	if($sessionUser->logedin){


	echo '<br /><br /><input type="button" onClick="logout()" value="Log Out" />';

	}else{
	
	
	}


}
?>