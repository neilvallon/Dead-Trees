<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>The Permutation are Endless</title>
</head>
<body>
<?php
function fix_for_page($value){
	$value = htmlspecialchars(trim($value));
	if(get_magic_quotes_gpc())
		$value = stripslashes($value);
	return $value;
}
$deck = explode(",", fix_for_page($_REQUEST['dataSet']));
$iteration = fix_for_page($_REQUEST['startIteration']);
$length = fix_for_page($_REQUEST['length']);
if(!is_numeric($iteration)) $iteration = 0;
if(!is_numeric($length)) $length = 0;

if(sizeof($deck)>8) die("To Many Values. sorry.<br /><a href='index.html'>Back</a>");
$time_start = microtime(true);
require("swapPattern.php");
?>
<br /><br /><br /><div style="position:absolute;top:10px;right:10px;font-size:12px;color:#616161;text-align:center;">
<?php
$time_end = microtime(true);
$time = $time_end - $time_start;
echo 'Generated: '.$resultCount." results - in: ".round($time, 4)." seconds.";
?>
<br />&copy; 2010 - Neil Vallon</div>
</body>
</html>