<?php
ob_start();
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
require_once('includes/session.php'); ?>
<html>
<head>
<script src="includes/jquery-1.6.2.js"></script>
<script src="includes/ajaxRequests.js"></script>
</head>
<body>
<?php require_once('getPage.php'); ?>
<br /><br /><br />
<div id='status'></div>
<pre>

<?php print_r($_SESSION); ?>

<?php print_r($_COOKIE); ?>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.'."\n";
?>
</pre>
</body>
</html>