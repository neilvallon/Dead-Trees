<?php require_once("../../_/header.php"); ?>

<p>
	The only reason I'm proud of this is because I discovered the ordering and algorithm without Google.<br />
	I may at some point move it over to JS... That point is not today.<br />
	I may also upload the pages of me cursing at my failed atempts... That day may be sooner.<br /><br />
</p>

<form method="post" action="result.php">
	  <p>
      Enter comma-separated values. Limit 8.
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

<?php require_once("../../_/footer.html"); ?>