<?php
/***
 * PHP PigLatin Translator
 * @copyright (c) 2009 Neil Vallon - <neilvallon[at]gmail.com>
 */
 
function fix_for_page($value){
	$value = htmlspecialchars(trim($value));
	if(get_magic_quotes_gpc())
		$value = stripslashes($value);
	return $value;
}

function countChars($string, $charSet, $fromEnd, $inverseCheck){
	$inSet = true;
	$atEnd = false;
	if($fromEnd){
		$a = -1;
	}else{
		$a = 0;
	}
	do{
		$charToCheck = substr($string, $a, 1);
		if($inverseCheck){
			$countSymbol = !in_array($charToCheck, $charSet);
		}else{
			$countSymbol = in_array($charToCheck, $charSet);
		}
		if($countSymbol){
			if($fromEnd){
				$a--;
			}else{
				$a++;
			}
		}else{
			$inSet = false;
		}
		if($fromEnd and $a <= -(strlen($string)+1)){
			$atEnd = true;
		}else if(!$fromEnd and $a >= strlen($string)){
			$atEnd = true;
		}
	}while($inSet and !$atEnd);
	if($fromEnd){
		$a = ($a+1)*-1;
	}
	return $a;
}

/***
 * Start of Script
 */
$characterSet = array('`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '=', '+', '{', '[', ']', '}', '|', ';', ':', '"', '\'', '<', ',', '>', '.', '?', '/');
$vowelSet = array('a', 'e', 'i', 'o', 'u');
$inputString = $_REQUEST['msg'];
$isHyphen = $_REQUEST['hyf'];
if($isHyphen){
	$hyphen = "-";
}else{
	$hyphen = "";

}
$wordsTranslated = 0;
$inputString = nl2br(strtolower(strip_tags(stripslashes(trim($inputString)))));
$inputString = str_replace("<br />", " ~ ", $inputString);
$words = explode(" ", $inputString);
$endStr = "";
foreach($words as $word){
	$word = trim($word);
	$beginingChars = "";
	$endingChars = "";
	if(is_numeric($word) or $word == NULL or in_array($word, $characterSet)){
		$pigWord = $word;
	}else{
		if(in_array(substr($word, 0, 1), $characterSet)){
			$numOfChars = countChars($word, $characterSet, false, false);
			$beginingChars = substr($word, 0, $numOfChars);
			$word = substr($word, $numOfChars);
		}
		if(in_array(substr($word, -1, 1), $characterSet)){
			$numOfChars = countChars($word, $characterSet, true, false);
			$endingChars = substr($word, -($numOfChars));
			$word = substr($word, 0, -($numOfChars));
		}
		if(!is_numeric($word) and $word != NULL and !in_array($word, $characterSet)){
			$wordsTranslated++;
			if(in_array(substr($word, 0, 1), $vowelSet)){
				$word = $word.$hyphen."way";
			}else{
				if(substr($word, 0, 2) == 'qu'){
					$numOfChars = 2;
				}else{
					$numOfChars = countChars($word, $vowelSet, false, true);
				}
				if($numOfChars >= strlen($word)){
					$pigWord = $beginingChars.$word.$endingChars;
				}else{
					$beginingConsts = substr($word, 0, $numOfChars);
					$word = substr($word, $numOfChars);
					$word = $word.$hyphen.$beginingConsts."ay";
				}
			}
		}
		$pigWord = $beginingChars.$word.$endingChars;
	}
	$endStr .= $pigWord." ";
}

$sender = $_REQUEST['sender'];
if($sender != NULL){
	mail($sender, "igpay atinlay", $endStr, "From: pig@neilvallon.com.com\r\n");
}

$endStr = trim(str_replace(" ~ ", "\n", fix_for_page($endStr)." "));

?>