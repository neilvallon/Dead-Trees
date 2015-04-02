<?php require_once("../../_/header.php"); ?>

<?php
function fix_for_page($value){
	$value = htmlspecialchars(trim($value));
	if(get_magic_quotes_gpc())
		$value = stripslashes($value);
	return $value;
}
$input = explode(',', fix_for_page($_REQUEST['dataSet']));
$iteration = fix_for_page($_REQUEST['startIteration']);
$length = fix_for_page($_REQUEST['length']);
if(!is_numeric($iteration)) $iteration = 0;
if(!is_numeric($length)) $length = 0;

if(sizeof($deck)>9) die('To Many Values. sorry.<br /><a href="index.html">Back</a>');
require('swapPattern.php');
?>

<div style="position:absolute;top:10px;right:10px;font-size:12px;color:#616161;text-align:center;">
<?php
echo 'Generated: '.$length.' results - in: '.round($time, 4).' seconds.<br />';
echo (1/$time)*$length." per second";
?>
</div>

<?php require_once("../../_/footer.html"); ?>