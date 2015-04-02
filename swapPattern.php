<?php  echo "&nbsp;&nbsp;";

function getTime(){
$mtime = explode(" ", microtime()); 
return $mtime[1] + $mtime[0]; 
}


function makeArray($p){
	global $factorialArray;
	return $factorialArray[] = $p? $p*makeArray($p-1):1;
}

function moveToEnd($input, $value){
	$input[] = $input[$value];
	unset($input[$value]);
	return array_values($input);
}

function makePerm($input, $iteration){
	global $inputSize, $factorialArray;
	for($i=0;$i<=$inputSize;++$i){
		if($iteration >= $factorialArray[$i]){
			$input = moveToEnd($input, $i);
			$iteration -= $factorialArray[$i];
			--$i;
		}else echo $input[$i]; //removes need for loop... does nothing.. delete if needed
	}
	 echo $input[$i].'&nbsp;&nbsp; &nbsp;&nbsp;'; //removes need for loop... does nothing.. delete if needed
	//return $input;
}
 
$starttime = getTime();
/////
$inputSize = sizeof($input);

makeArray($inputSize);
$factorialArray[0] = $factorialArray[$inputSize];
unset($factorialArray[$inputSize]);
$factorialArray = array_reverse($factorialArray);

$inputSize -= 2; //set up for loops later



if(!$length or $length+$iteration>=($factorialArray[$inputSize+1])) $length = ($factorialArray[$inputSize+1])-$iteration;

$LpH = $length+$iteration;
for($i=$iteration;$i<$LpH;++$i) /*sort $why[] =*/ makePerm($input, $i);

/* sort
foreach($why as $not){
	foreach($not as $omg) $temp .= $omg;
	$wtf[] = $temp;
	$temp=NULL;
}
if(is_numeric($wtf[0])) sort($wtf, SORT_NUMERIC);
foreach($wtf as $aboutTime) echo $aboutTime.", ";
*/

$time = (getTime() - $starttime); ?>