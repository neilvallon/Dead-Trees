<?php

function makeDeck(){
	global $deckSize;
	$factorialArray[$deckSize] = 1;
	for($i=($deckSize-1);$i>=0;$i--) $factorialArray[$i] = ($deckSize - $i)*$factorialArray[$i+1];
	return $factorialArray;
}

$deck = array("1", "2", "3", "4", "5");
$resultCount = 0;
$deckSize = 52;

print_r(makeDeck());
/*
$deck = array("A-C", "A-D", "A-H", "A-S", "K-C", "K-D", "K-H", "K-S", "Q-C", "Q-D", "Q-H", "Q-S", "J-C", "J-D", "J-H", "J-S", "10-C", "10-D", "10-H", "10-S", "9-C", "9-D", "9-H", "9-S", "8-C", "8-D", "8-H", "8-S", "7-C", "7-D", "7-H", "7-S", "6-C", "6-D", "6-H", "6-S", "5-C", "5-D", "5-H", "5-S", "4-C", "4-D", "4-H", "4-S", "3-C", "3-D", "3-H", "3-S", "2-C", "2-D", "2-H", "2-S");
*/
?>