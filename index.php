<?php
require_once('session.php');
?>
<html>
<head>
<script src="jquery-1.6.2.js"></script>

<script type='text/Javascript'>
function signUp(){
	$.post("post.php", { action: "signUp", email: $('#email').val(), pass: $('#pass').val() }, 
		function(data){
			$('#status').html(data);
		});
}
function login(){
	$.post("post.php", { action: "login", email: $('#email').val(), pass: $('#pass').val() }, 
		function(data){
			$('#status').html(data);
		});
}
function logout(){
	$.post("post.php", { action: "logout", email: $('#email').val(), pass: $('#pass').val() }, 
		function(data){
			$('#status').html(data);
		});
}
</script>
</head>


<body>
<?php if(!$sessionUser->logedin){ ?>
<form>
Username:<br>
<input type="text" id="email" size="60"><br>
Password:<br>
<input type="password" id="pass" size="60"><br>
<input type="button" value="Create user" onclick="signUp()">
<input type="button" value="login" onclick="login()">
</form>
<?php }else{ ?>

<br />
You are now loged in! <input type="button" value="log out" onclick="logout()" />
<br />

<?php } ?>
<div id='status'></div>
</body>
</html>