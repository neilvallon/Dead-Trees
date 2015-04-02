<?php require_once("http://neilvallon.com/_/header.php"); ?>

<form method="post" action="result.php">
	  <p>
      Enter comma-separated values. Limit 8 so my web host doesn't beat me over the head with a stick.
      <br />
	    <input type="text" id="dataSet" name="dataSet" value="1,2,3,4,5,6" size="40" />
        <br /><br />
        Starting Iteration: <input type="text" id="startIteration" name="startIteration" value="0" size="8" />
        <br />
        Number of Permutations: <input type="text" id="length" name="length" value="0" size="8" />
        <br />
         Leave Both "0" to show all Permutations.
         <br />
	    <input type="submit" name="button" id="button" value="Go" />
    </p>
</form>

<?php require_once("http://neilvallon.com/_/footer.html"); ?>