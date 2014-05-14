<?php

function get_tiny_url($url) // generates a mini-url out of the long string that is given latter in the page alowing short urls without forcing us to maintain an SQL database
{
/* 
next few lines just converts special characters into there html ecoded equivelent to stop errors or part of the string from being cut off
*/
$url = str_replace(" ", "%20",$url);
$url = str_replace("#", "%23",$url);
$url = str_replace(";", "%3B",$url);
$url = str_replace("+", "%2B",$url);
$url = str_replace("%", "%25",$url);
$url = str_replace("&", "%26",$url);


//$url = str_replace("%", "%25",$url);

/*

next few lines does a get request from is.gd so we can shorten the url and present it on our page without having the user actoualy go to the shortening service website

basicly its like downloading the content from another page on the internet and stuffing it into a veriable

*/


	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,'http://is.gd/api.php?longurl='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}




function fix_for_page($value){ //makes it so we dont have hacking prolems

$value = str_replace("&", "",$value);

    $value = htmlspecialchars(trim($value));
    if (get_magic_quotes_gpc()) 
        $value = stripslashes($value);
	

    return $value;
}

$url = fix_for_page($_REQUEST['url']);
$width = fix_for_page($_REQUEST['width']);
$height = fix_for_page($_REQUEST['height']);
$color = fix_for_page($_REQUEST['color']);
$title = fix_for_page($_REQUEST['title']);
$texts = fix_for_page($_REQUEST['texts']);

$color = str_replace("#", "",$color); //the javascript color selector automaticly adds these to the url which can cause problems so we will just take them out and code them directly into the page without any scripting

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $title." - ".$texts; ?></title>
<?php

$size = getimagesize($url); // the next few lines are for the resizing function... it is in absolutly no way perfect or even optomized
//allot could be changed here but the basic idea is to take in the images width and height and what the person wants the width and height to be and rezize it to thoes dimetions while maintaining aspect ratio and not causing pixilation by upscaleing upless specified in the previouse page

if($size[0] > $size[1] && is_numeric($width)){

if($upscale == true){
$height = ($width/$size[0])*$size[1];
}else{
if($width > $size[0]){
$width = $size[0];
$height = $size[1];
}else{
$height = ($width/$size[0])*$size[1];
}
}

}elseif(is_numeric($height)){

if($upscale == true){
$width = ($height/$size[1])*$size[0];
}else{
if($height > $size[1]){
$width = $size[0];
$height = $size[1];
}else{
$width = ($height/$size[1])*$size[0];
}
}

}

?>
<style type="text/css">
body{
background-color:#000000;
color:#666666;
}

img{
border:#<?php echo $color; ?> 1px solid;
}

.borderd{
border:1px #FFFFFF solid;
}

.insidePad{
padding:25px;
color:#FFFFFF;
text-align:center;
}

.text32{
font-size:64px;
font-family:lighter "Times New Roman", Times, serif;
text-transform:uppercase;
text-decoration:underline;
color:#<?php echo $color; ?>;
}
.ends{
font-size:80px;
font-family:lighter "Times New Roman", Times, serif;
text-transform:uppercase;
position:relative;
top:10px;
color:#<?php echo $color; ?>;
}
.bottoms{
text-transform:capitalize;
font-size:18px;
font-weight:lighter;
}
</style>
</head>

<body>
<center>
<table width="1" height="1">
<tr>
<td>
<div class="borderd">
<div class="insidePad">
<img src="<?php echo $url; ?>" <?php if($width != NULL){ ?>width="<?php echo $width."\""; } ?> <?php if($height != NULL){ ?>height="<?php echo $height."\""; } ?> />
<?php  ?>
<span class="ends"><?php echo $title[0]; ?></span><span class="text32"><?php echo substr($title, 1, -1); ?></span><span class="ends"><?php echo substr($title, -1); ?></span>
<br />
<span class="bottoms"><?php echo $texts; ?></span>
</div>
</div>
</td>
</tr>
</table>
<br />
<br />
<?php
$link = "http://motivation.neilvallon.com/view.php?title=".$title."&texts=".$texts."&url=".$url."&color=".$color."&width=".$width."&upscale=".$upscale; //link to this exact poster
if($_REQUEST['t'] != true){//if this is the first time to the page present a question to generate a url to this page. we dont want it to automaticly generate it to respect the short url bandwidth limitations
?>
<a href="<?php echo $link."&t=true" ?>">Generate Link</a>
<?php
}else{ // if they clicked the generate link button then preform the shortoning function at the top of the page and echo it out
if($_REQUEST['m'] != true){
$link = get_tiny_url($link."&m=true&t=true");
?>
Link: <a href="<?php echo $link."\">".$link ?></a><?php } } ?>
</center>
</body>
</html>