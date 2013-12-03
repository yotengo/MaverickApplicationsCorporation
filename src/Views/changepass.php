<?php
require ("../Controller.php");
require ("../View.php");
$control=new Controller();


echo "<html>".PHP_EOL;
// echo "			<div class=\"panel right\">".PHP_EOL;
echo "<body>".PHP_EOL;
echo "				<h1>New to HALlo?</h1>".PHP_EOL;
// echo "				<p>".PHP_EOL;
echo "		<form action=\"temp.php\" method=\"post\">".PHP_EOL;
echo "			<input name=\"Password\" type=\"password\" placeholder=\"Password\">".PHP_EOL;
echo "		    <input name=\"NewPass\" type=\"password\" placeholder=\"New Password\">".PHP_EOL;
echo "			<input name=\"NewPass2\" type=\"password\" placeholder=\"Confirm New Password\">".PHP_EOL;
echo "		   	<button type=\"submit\" name=\"changepass\" value=\"Submit Form\" onclick=\"return true\">".PHP_EOL;
echo "Change Password";
echo "</button>";
echo "					</form>".PHP_EOL;
// echo "			</p>".PHP_EOL;
// echo "		</div>".PHP_EOL;
				
echo "</body>".PHP_EOL;	
			
echo "</html>".PHP_EOL;			
			
?>