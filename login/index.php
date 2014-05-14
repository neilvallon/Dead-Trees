<?php
ob_start();
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
require_once('includes/session.php');

if(!isset($_POST['rem'])) $_POST['rem'] = false;

if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['rem'])){
	$sessionUser->login($_POST['email'], $_POST['pass'], $_POST['rem']);
}

if(!isset($_REQUEST['pageID'])) $_REQUEST['pageID'] = NULL;
	switch($_REQUEST['pageID']){
		case 'signUp':
			require_once('templates/signUp.php');
			break;
		case 'logout':
			$sessionUser->logout();
			require_once('templates/login.php');
			break;
		default:
			require_once('templates/login.php');
		break;
	}



?>
<div style="position:absolute;top:8px;right:8px;">
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<h5>Page generated in '.$total_time.' seconds.</h5>';
?>
</div>