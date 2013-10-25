<?php //function to start the exectution timer
function microtime_float(){
	list($utime, $time) = explode(" ", microtime());
	return ((float)$utime + (float)$time);
}
$script_start = microtime_float();
?>

<?php
function fix_for_page($value){ //function that converts symbols (like &) that don't play nice with html into there encoded counterpart (&amp;)
	$value = htmlspecialchars(trim($value));
	if (get_magic_quotes_gpc())
		$value = stripslashes($value);
	return $value;
}

function cons_count($word){ //function that counts the number of consonants at the begining of a word so that they can be moved to the end of the word later in the script

	if(substr($word, 0, 2) == "qu"){ // words like "question" need to be converted to "estion-quay" not "uestion-qay"... this does that by skiping the counting step and just treating the first 2 letters as consonants
		$a = 2;
	
	}else{
		$a = 1; //since we already know that the first letter is a consonant theres no point in checking it again so this sets it to the second letter
		$i = substr($word, $a, 1); //sets the value of $i to the $a position of $word and copys 1 letter
		
		while(!in_array($i, array("a", "e", "i", "o", "u", "y")) && $a < strlen($word)){ //while the selected letter ($i) is not a vowel and the number of consonants is more than the length of the word (a word with no vowels or with only characters)
			$a++; //add 1 to the number of constanants
			$i = substr($word, $a, 1); //reset $i to the next letter in the word
		
		}
	
	}
	return $a; //returns the number of consonants... phone would return 2... tape would return 1

}

$msg = $_REQUEST['msg']; //the next 2 lines just resets the values to themselves... this is required in order to work in php5
$sender = $_REQUEST['sender'];
$hyf = $_REQUEST['hyf'];

if($hyf == true){ //far from perfect but cheap and dirty way to add hyphen suport
	$hyf = "-";
}else{
	$hyf = "";
}

$msg = nl2br(strtolower(strip_tags(stripslashes($msg)))); //cleans up the message a bit by striping any \'s HTML tags then converts the entire thing to lowercase since the script is case sensitive and finaly it makes any new lines to <br> tags to prevent crashes without entirely taking them out
$msg = str_replace("<br />", " ~ ", $msg); //since the script is only looking at one character at a time we need to have a special character that can pass through the script unchanged
$words = explode(" ", $msg); //splits the string into individual words
$wordsTranslated = 0; //set the word counter to 0

foreach($words as $word){ //for every word in the array
	$word = trim($word); //trim off any white space and other things that ar not needed and cause extra work and bad trancelations
	
	if(!is_numeric($word)){ //if the word is actualy a number we don't want to change it any
		$firstLetter = substr($word, 0, 1);//next 4 lines sets up the veriables needed to properly place characters like quotes and puncuation
		$lastLetter = substr($word, -1, 1);
		$wordBeg = "";
		$wordEnd = "";
		$w = strlen($word);
		$a=1;
		
		while(in_array($firstLetter, array('`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '=', '+', '{', '[', ']', '}', '|', ';', ':', '"', '\'', '<', ',', '>', '.', '?', '/')) && $a < $w){ //if the first character matches any of these symbols
			$wordBeg .= $firstLetter; //set $wordBeg veriable that will be atached to the end of the word after it is converted
			$word = substr($word, 1); //reset the $word to itself minus the first character
			$firstLetter = substr($word, 0, 1); //resets the first character to the proper value
            $a++;
		}
		
		$w = strlen($word);
		$a=0;
		while(in_array($lastLetter, array('`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '=', '+', '{', '[', ']', '}', '|', ';', ':', '"', '\'', '<', ',', '>', '.', '?', '/')) && $a < $w){ //does the same as above but with the last letter
			$wordEnd .= $lastLetter;
			$word = substr($word, 0, -1);
			$lastLetter = substr($word, -1, 1);
			$a++;
		}
		
		if(in_array($firstLetter, array("a", "e", "i", "o", "u"))){ //if the first letter is a vowel
			$pigWord = $wordBeg.$word.$hyf."way".$wordEnd; //set the finished word to the wordbegining (if any) the word itself, a hyphen if the option was selected, and the word end
		
		}else{
			$numConst = cons_count($word); //use the above function to count the number of consonants in $word
			
			if($numConst >= strlen($word)){ //if there where no vowels in the word
				$vowelend = ""; //dont add anything to the end
				$hyf = ""; //makes sure that a hyphen is not added
			
			}else{
				$vowelend = "ay"; //if everything is normal then add an "ay" to the end
			}
			
			$leadingCons = substr($word, 0, $numConst); //sets up a veriable with the consonants at the begining of the word in it so they can be moved to the end
			$pigWord = $wordBeg.substr($word, $numConst).$hyf.$leadingCons.$vowelend.$wordEnd; //set the finished word to the wordbegining (if any) the word itself without any of the consonants at the begining, a hyphen if the option was selected, the leading consonants, the vowel end, and finaly and the word end
		}
	$wordsTranslated++; //add 1 to the word counter (not 100% acurate due to it counting spaces and breaks)
	
	}else{
	$pigWord = $word; //if the word was numeric just pass it through as if it where translated
	
	}
	
	$endStr .= $pigWord." "; //add the translated word to the curent sentence with a space and move on to the next word
}

if($sender != NULL){ //if there is a sender (the string was emailed to pig@neilvallon.com)
	mail($sender, "igpay atinlay", $endStr, "From: pig@neilvallon.com.com\r\n"); //Sent the translated string back to them
}

$endStr = trim(str_replace(" ~ ", "\n", fix_for_page($endStr)." ")); //convert the ~'s back into <br> tags and any special characters into HTML coded characters
?>
<textarea name="msg" id="msg" cols="50" rows="10"><?php echo $endStr; ?></textarea>
<?php //stops the execution time counter and echos the footer with how long the script took and how many words it translated
$script_end = microtime_float();
echo '<br /><br /><br /><span style="font-size:12px;color:#616161;text-align:center;">Translated: ~'.$wordsTranslated." Words - in: ".bcsub($script_end, $script_start, 4)." seconds.<br />&copy; 2009 - Neil Vallon</span>";
?>