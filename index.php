<?php $databasepass = 'dhasjkh&^7*dsfsdYIJ7345^5$34ds5^43adf(7n43G5434Hjk324gd43kl4sf4j2343sh3afk24ji5u5s2d2f2586sd7'; ?>
<?php session_start(); include("db.php"); //Starts sesion and includes database?>




<?php $fileN = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //figure out where the page is located?>

<?php if ($action == 'endco'){ // log out action
session_destroy(); // end sesion
echo '<a href="?action=admin">Click Here To Continue</a>'; // echos link to go back to login page
}
?>

<?php if ($action == 'setco'){ // login action
$_SESSION['usrnam'] = $_REQUEST['user']; // sets sesion username
$_SESSION['paswrd'] = md5($_REQUEST['pass']); // sets sesion password
echo '<a href="?action=admin">Click Here To Continue</a>'; // link to go to the login panel or admin panel dependin on if the login was successfull
}
?>

<?php if ($action != 'admin'){ // if action is not set to admin?>
<?php
$input_arr = array();
foreach ($_REQUEST as $key345 => $input_arr) {
    $_REQUEST[$key345] = addslashes(strip_tags($input_arr));
}
?>

<?php if ($action == 'remove'){ // remove email action?>
<?php
	
	$remove = $_REQUEST['remove']; // request from form
	
	if($remove != NULL){ // if an email was entered

mysql_select_db($database_Connect, $dbConnect); // select DB
	
$sql = "SELECT `rem` FROM nletter WHERE `email` = '$remove'"; // finds the value of rem for the email entered

	$query = mysql_query($sql, $dbConnect) or die(mysql_error());
	
	mysql_query($sql, $dbConnect) or die(mysql_error());
	
	$send = mysql_fetch_row($query);
	
	if($send != NULL){ // if removal code exist
	
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: '.$from . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; // html email hedders

$msg = "Please go to the site below to confirm that you want to be removed from our newsletter.<br /><br /><a href='".$fileN."&rem=".$send[0]."'>".$fileN."&rem=".$send[0]."</a>"; // sets mesage to be sent to confirm that they wish to be removed

mail($remove, "Newsletter Confirmation",  $msg, $headers); // sends email

echo "An email has been sent to ".$remove." with a removal URl.<br /><a href='?action=remove'>Back</a>"; // tells the user that an email has been sent with a removal link
	}else{
	echo "Sorry but the email you entered does was not found in our database. Please try again<br /><a href='?action=remove'>Back</a>"; // says there was an error
	}
	}else{ //end removal email?>
	
	<form method="post" action="<?php echo $fileN ?>">

  Your Email:<input type="text" name="remove">
  <input type="submit" name="Submit" value="Remove">
  
</form>
<a href="?action=">Add</a> | <a href="?action=remove">Remove</a> | 
<?php 
if(isset($_SESSION['usrnam'])){
echo '<a href="?action=admin">Admin</a>';
}else{
echo '<a href="?action=admin">Login</a>';
}
?>
	
	<?php
	}
	if($rem != NULL){ // the action used to actualy remove the email

mysql_select_db($database_Connect, $dbConnect);
	
$sql = "DELETE FROM `nletter` WHERE `rem` = '$rem'"; // delete email where rem is = to $rem. $rem is the veriable sent in the email
			
	$query = mysql_query($sql, $dbConnect) or die(mysql_error());

	if($query){
	echo "<br /><br />You where successfully removed from our newsletter."; // tells user they where removed ?>
<?php } ?>
<?php } ?>
<?php } //end remove action?>


<?php if ($action == 'add'){ // action to send email to add user?>
<?php
$email = $_REQUEST['email'];

if($email != NULL){

$subject = 'Newsletter Confirmation'; // sets subject line

$message = 'Please go to the site below to confirm that you want to sign up for our newsletter.<br /><br /><a href="'.$fileN.'&mail='.$email.'">'.$fileN.'&mail='.$email.'</a>'; // sets message

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: '.$from . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

mail($email, $subject, $message, $headers); // sends email

echo "An email has been sent to ".$email." with a confirmation link.<br /><a href='?action='>Back</a>";

}elseif($mail != NULL){ // if coming to this page from the email add link

mysql_select_db($database_Connect, $dbConnect);

$rem = md5(rand(1, 99999).$mail); // generates a random code to be used in removal

$sql = "INSERT INTO `nletter` (`email`, `rem`) VALUES ('$mail', '$rem')"; // adds user to database
			
	$query = mysql_query($sql, $dbConnect) or die(mysql_error());
	
	if($query){
	echo "You have sucsesfully been added to our newsletter<br /><a href='?action='>Back</a>"; // tells user they where added
	}
	}else{
echo "Error! Please enter an email address.<br /><a href='?action='>Back</a>"; // message if no email address was entered
	}
?>
<?php } //end add?>

<?php if ($action == NULL){ // if no action set?>
<form method="post" action="?action=add">

 Your Email:<input type="text" name="email" />
 
 <input type="submit" value="Sign Up!" />
 
</form>
<a href="?action=">Add</a> | <a href="?action=remove">Remove</a> | 
<?php 
if(isset($_SESSION['usrnam'])){
echo '<a href="?action=admin">Admin</a>';
}else{
echo '<a href="?action=admin">Login</a>';
}
?>
<?php } // end main page?>

<?php }else{ // if admin action is set ?>

<?php

if($_SESSION['usrnam'] == $sendUser && $_SESSION['paswrd'] == $sendPass){ // if username and password are correct
?>
<form method="post" action="?action=admin">
Subject: <input name="sub" type="text" /><br />
Message: <textarea name="msg" rows="15" cols="40"></textarea><br />
<input type="submit" value="Send" />
</form>
<a href="?action=">Add</a> | <a href="?action=remove">Remove</a> | <a href="?action=endco">Log Off</a>
<?php
$message = stripslashes(nl2br(htmlentities($_POST['msg'], ENT_QUOTES)));
	
  if($message != NULL){ // if a message was entered
  
  $subject = stripslashes($_POST['sub']);

	mysql_select_db($database_Connect, $dbConnect);
	
	$sql = "SELECT * FROM nletter"; // selects all users from database
			
	$send = mysql_query($sql, $dbConnect) or die(mysql_error());
	
	echo '<br /><br />';

	while ( $row = mysql_fetch_assoc($send) ) {
		
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: '.$from . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

mail($row['email'], $subject, $message, $headers); // sends email one user at a time to avoid 500 or other error

echo "Sent to: ".$row['email']."<br />"; // tells you who it was sent to
		
		}
		
		echo "<br />Done."; // tells you when its done sending
		
		} // end email

?>
<?php }else{ // if user name or password are wrong?>
<?php session_destroy(); // end sesion?>
<form method="post" action="?action=setco">
  <p>Username:
    <input type="text" name="user" />
 </p>
  <p>   
    Password:
    <input type="password" name="pass" />
    </p>
  <p>
    <input type="submit" value="Login" />
  </p>
</form>
<a href="?action=">Add</a> | <a href="?action=remove">Remove</a> | <a href="?action=admin">Login</a>
<?php } ?>
<?php } ?>