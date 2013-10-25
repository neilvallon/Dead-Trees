<?php
/*

the folowing code is the function that are used by the script

to see where the script actualy starts, skip down to the comment "//start of script"

*/

function is_vowel($firstLetter){ //input: a letter - output: true or false
switch ($firstLetter) {
    case 'a':
        $isTrue = true;
        break;
	case 'e':
        $isTrue = true;
        break;
	case 'i':
        $isTrue = true;
        break;
	case 'o':
        $isTrue = true;
        break;
	case 'u':
        $isTrue = true;
        break;
	case 'y':
        $isTrue = true;
        break;
    default:
       $isTrue = false;
}
return $isTrue;	
}


function cons_count($word){ //input: a word - output: number of constanants befor a vowel
	$a = 0; //counter for the number of constanance
	$i = substr($word, $a, 1); //probably not needed but added just in case to make the while statment false
	while(!is_vowel($i)){ //while the next letter is not a vowel
		$a++; //add one to the contanant count
		$i = substr($word, $a, 1); //set $i to the lext letter
	}
	return $a;
}

//Start of script
$msg = strtolower($msg); //converts the string to lowercase so that the "is_vowel()" function doesnt have to worry about capital letters

$words = explode(" ", $msg); //splits the string up into words "hello my name is neil vallon" = array(hello, my, name, is, neil, vallon)

foreach($words as $word){ //for every word in the sentence - convert it to pig latin
	
$firstLetter = substr($word, 0, 1); //selects the first letter in the word
	if(is_vowel($word)){ //if the first letter is a vowel
	$pigWord = $word."way"; //add "way" to the end and move on to the next word
	}else{ //if it is a constanant
		$numConst = cons_count($word); //cont the number of constanants before the first vowel ocures
		$leadingCons = substr($word, 0, $numConst); //starting at the begining of the word selects all the letters at the begining that are constanants and puts them into a veriable
		$pigWord = substr($word, $numConst).$leadingCons."ay"; //selects the word without the leading constanants and put them on the end with "ay" then moves on to the word
	}
	
	$endStr .= $pigWord." "; //puts the pig latin word that was just generated on to the end of string so far with a space
	
}

echo $endStr; //echos the finished sentence

if($sender != NULL){ //this is so that if the page was oppened using my applescript code it can send the finished mesage back
mail($sender, "igpay atinlay", $endStr, "From: 8ball@neilvallon.com.com\r\n");
}

?>