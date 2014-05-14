<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo !$sessionUser->logedin?'Login':'Results'; ?></title>
<link rel="stylesheet" href="_/reset.css"> 
<style type="text/css">
body{
	background:#ddd;
}
.wrapper{
	position:relative;
	top:25px;
	margin:auto;
	width:380px;
}
.content{
	padding:25px;
	background:#fff;
	border:2px solid #777;
	-moz-border-radius: 15px;
	border-radius: 15px;
}
.heading{
	position:relative;
	top:9px;
	left:20px;
	font:36px Helvetica;
	font-weight:900;
	color:#444;
}
</style>
</head>
<body>
	<div class="wrapper">
		<div class="heading"><?php echo !$sessionUser->logedin?'Login':'Results'; ?></div>
		
        <div class="content">
        	<?php if(!$sessionUser->logedin){ ?>
				<form action="index.php?pageID=login" method="post">
					Username:<br />
					<input type="text" name="email" style="width:320px;" /><br />
					Password:<br />
					<input type="password" name="pass" style="width:320px;" /><br />
					<input type="checkbox" name="rem" /> Remember Me<br />
					<div style="width:100%;text-align:right;"><input type="submit" value="login" style="width:100px;" /></div>
			</form>
            <?php
			}else{
				var_dump(get_defined_vars());
				?>
				<div style="width:100%;text-align:right">
					<input type="button" value="logout" style="width:100px;" onClick="parent.location='index.php?pageID=logout'">
				</div>
				<?php
			}
			?>
            <div style="color:#ff5555;width:100%;text-align:center;"><?php echo $sessionUser->output; ?></div>
		</div>
        <div style="position:relative;top:-18px;text-align:center;font-size:12px;color:#777;">&copy; 2011 - Neil Vallon</div>
	</div>
</body>
</html>
