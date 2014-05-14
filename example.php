<?php
require('lazyval.php');

$outsideVar = "This will only be printed once.\n";
$val1 = new Lazyval(function() use (&$outsideVar){
	echo $outsideVar;
	sleep(2);
	echo "This will as well.\n";
	
	return "Result to be returned with each call.";
});

for($i=0; $i<10; ++$i)
	echo $val1->get()."\n";
