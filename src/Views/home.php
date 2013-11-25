<?php
require("../Controller.php");
require("../View.php");

	function load(){
		$view = new View();
		$view->displayHeader("home2.php");
	}
	load();
	exit;
	echo "<html>";
	echo "<head>";
		echo "<title>";
		echo "Home";
		echo "</title>";
	echo "</head>";
	echo "<body>";
	// load();
		// bring in a bunch of info here	
			echo "Future posts will show here";
			"This is the home page";
		
	echo "</body>";
echo "</html>";
?>