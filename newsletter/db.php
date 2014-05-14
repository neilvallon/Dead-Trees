<?php
if($databasepass == 'dhasjkh&^7*dsfsdYIJ7345^5$34ds5^43adf(7n43G5434Hjk324gd43kl4sf4j2343sh3afk24ji5u5s2d2f2586sd7'){
//admin send panel info

	$from = 'your_email@yoursite.com'; // email address to send from
	$sendUser = 'admin'; //username for the admin/send panel
	$sendPass = md5('admin'); //password for admin/send panel
	
	
	//SQL info
	
	$hostname_Connect = "*****"; // SQL server
	$database_Connect = "*****"; // SQL database
	$username_Connect = "*****"; // SQL username
	$password_Connect = "*****"; // SQL password
	
	
	$dbConnect = mysql_pconnect($hostname_Connect, $username_Connect, $password_Connect) or die(mysql_error());
}
?>