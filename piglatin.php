<?php 
function microtime_float()
{
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

$script_start = microtime_float();
?> 

<?php
/*

the folowing code is the function that are used by the script

to see where the script actualy starts, skip down to the comment "//start of script"

*/


function cons_count($word){ //input: a word - output: number of constanants befor a vowel

if(substr($word, 0, 2) == "qu"){ //qu word beguining fix so that word like quiet are properly trancelated to ietquay instead of uietqay
	$a = 2;
}else{
	$a = 1; //counter for the number of constanance
	$i = substr($word, $a, 1); //probably not needed but added just in case to make the while statment false
	while(!in_array($i, array("a", "e", "i", "o", "u", "y")) && $a < strlen($word)){ //while the next letter is not a vowel
		$a++; //add one to the contanant count
		$i = substr($word, $a, 1); //set $i to the lext letter
	}
}
	return $a;
}

//Start of script
if($hyf == true){
	$hyf = "-";
}else{
	$hyf = "";	
}
$msg = strtolower(strip_tags($msg)); //stripts HTML tags and converts the string to lowercase

$words = explode(" ", $msg); //splits the string up into words "hello my name is neil vallon" = array(hello, my, name, is, neil, vallon)

foreach($words as $word){ //for every word in the sentence - convert it to pig latin
	
	if(!is_numeric($word)){
	
$firstLetter = substr($word, 0, 1); //selects the first letter in the word
$lastLetter = substr($word, -1, 1);

$wordBeg = "";
$wordEnd = "";
	
	if(in_array($firstLetter, array('(', '\'', '"', '*', '{', '['))){
		$wordBeg = $firstLetter;
		$word = substr($word, 1);
		$firstLetter = substr($word, 1, 0);
	}
	
	if(in_array($lastLetter, array(')', '\'', '"', '*', '.', ',', ';', ':', '!', '}', '{', '[', ']'))){
		$wordEnd = $lastLetter;
		$word = substr($word, 0, -1);
		$lastLetter = substr($word, -2, 0);
	}

	if(in_array($firstLetter, array("a", "e", "i", "o", "u"))){ //if the first letter is a vowel
	$pigWord = $wordBeg.$word.$hyf."way".$wordEnd; //add "way" to the end and move on to the next word
	}else{ //if it is a constanant
		$numConst = cons_count($word); //cont the number of constanants before the first vowel ocures
		
		if($numConst >= strlen($word)){
			$vowelend = "";
		}else{
			$vowelend = "ay";
		}
		
		$leadingCons = substr($word, 0, $numConst); //starting at the begining of the word selects all the letters at the begining that are constanants and puts them into a veriable
		$pigWord = $wordBeg.substr($word, $numConst).$hyf.$leadingCons.$vowelend.$wordEnd; //selects the word without the leading constanants and put them on the end with "ay" then moves on to the word
	}
	
	}else{
	$pigWord = $word;	
	}
	
	
	
	
	$endStr .= $pigWord." "; //puts the pig latin word that was just generated on to the end of string so far with a space
}

echo $endStr; //echos the finished sentence

if($sender != NULL){ //this is so that if the page was oppened using my applescript code it can send the finished mesage back
mail($sender, "igpay atinlay", $endStr, "From: pig@neilvallon.com.com\r\n");
}
?>

<?php 
   $script_end = microtime_float();
echo "<br><br><br>Script executed in ".bcsub($script_end, $script_start, 4)." seconds.";
?>