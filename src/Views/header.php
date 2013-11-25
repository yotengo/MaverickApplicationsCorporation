<?php
require("../Controller.php");
require("../View.php");
//require("../Model.php");


	$model= new Model();
	$view = new View();
	$control = new Controller();
	
	function logoff(){
		$model= new Model();
		$view = new View();
		$control = new Controller();
		if(isset($_POST['logoff'])){
			// echo("Test message");
			$control->logout();
			$view->displayLogin();
		}
	}

echo "<html>".PHP_EOL;

echo "<body bgcolor=\"aqua\">".PHP_EOL;
//<!--the above aqua color is a place holder and will (most likely) change when we nail down what to call the site-->

//<!--The style="float: right;" part is used to keep the logout on the right side of the header (since it looks nicer)-->

echo "<form name=\"login\" action=\"\" method=\"post\" onsubmit=\"return true\">".PHP_EOL;

echo "<button type=\"submit\" name=\"logoff\" onclick=\"logoff()\" value=\"Logout\" style=\"float: right;\">".PHP_EOL;
echo "Logout".PHP_EOL;
echo "</button>".PHP_EOL;
echo "</form>".PHP_EOL;
echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
logoff();
?>