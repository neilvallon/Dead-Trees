<?php
function factorial($num) { // 5!
	if ($num == 0) return 1;
	return $num * factorial($num - 1);
}

function place2end($deck, $pos){ //Rotate
	global $deckSize;
	$deck[($deckSize+1)] = $deck[$pos];
	array_splice($deck, $pos, 1);
	return $deck;
}

function getNextDeck($deck, $iteration){
	global $deckSize;
	
	//The magical bit
	for($i=0;$i<$deckSize;$i++){
		$rotationThreshold = factorial($deckSize-$i);
		$numRotations = floor($iteration/$rotationThreshold);
		for($x=0;$x<$numRotations;$x++) $deck = place2end($deck, $i-1);
		$iteration = $iteration - ($numRotations*$rotationThreshold);
	}
	//That was some David Blane shit right there, right?
	
	return $deck;
}
//Below this line I don't consider a vital part of the script

function printDeck($deck){
	global $deckSize;
	for($i=0;$i<$deckSize;$i++){
	echo " ".$deck[$i];
	}
}

function makeDeck($deck){
	global $deckSize, $resultCount, $iteration, $length;
	$fact = factorial($deckSize);
	if($length == 0 or $length+$iteration>=$fact) $length = $fact-$iteration;
	for($i=$iteration;$i<$length+$iteration;$i++){
		printDeck(getNextDeck($deck, $i));
		echo "<br />";
		$resultCount++;
	}
}

//$deck = array("2", "3", "4", "5", "3", "4", "5", "3", "4", "5", "3", "4", "5");
$resultCount = 0;
$deckSize = sizeof($deck);

makeDeck($deck);
/*
$deck = array("A-C", "A-D", "A-H", "A-S", "K-C", "K-D", "K-H", "K-S", "Q-C", "Q-D", "Q-H", "Q-S", "J-C", "J-D", "J-H", "J-S", "10-C", "10-D", "10-H", "10-S", "9-C", "9-D", "9-H", "9-S", "8-C", "8-D", "8-H", "8-S", "7-C", "7-D", "7-H", "7-S", "6-C", "6-D", "6-H", "6-S", "5-C", "5-D", "5-H", "5-S", "4-C", "4-D", "4-H", "4-S", "3-C", "3-D", "3-H", "3-S", "2-C", "2-D", "2-H", "2-S");
*/
?>