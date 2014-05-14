<?php
/*


This file is to only be run once. make sure the settings in db.php are correct.

this file creates the nessesary tables on the server and then tries to delete its's self since it will not be needed


*/

$databasepass = 'dhasjkh&^7*dsfsdYIJ7345^5$34ds5^43adf(7n43G5434Hjk324gd43kl4sf4j2343sh3afk24ji5u5s2d2f2586sd7';

$dbfile = "db.php"; // data file path







include($dbfile); // inclueds db.php which stores the info to conect to your SQL server

mysql_select_db($database_Connect, $dbConnect); // selects SQL database
	
$sql = 'CREATE TABLE `nletter` ('
        . ' `email` VARCHAR(50) NOT NULL, '
        . ' `rem` VARCHAR(50) NOT NULL,'
        . ' UNIQUE (`email`)'
        . ' )'
        . ' TYPE = myisam';
			
	$query = mysql_query($sql, $dbConnect) or die(mysql_error());
	
	if($query){ // if query successful
	
	echo "Tables sucsesfully added"; // tells you that it worked
	unlink($dbfile); // delete dbsetup.php (this file)
	
	}else{
	
	echo "Error please check setings in db.php and try again"; // says there was an error and you need to try again
	
	}
	
?>