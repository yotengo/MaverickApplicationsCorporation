<?php
require("../Controller.php");
require("../View.php");

	function login(){
		// $control = new Controller();
		// $control-> login();
		$view = new View();
		if(empty($_COOKIE)){
	// above check seems to work. Use it in the rest of the site
		 // echo "<p>logged in as nobody...</p>";
			$view->displayLoginSub();
		}else{
			$view->displayPageSub("home2.php");
		}
	}
	login();
	exit;
	// echo "<html>";
	// echo "<head>";
		// echo "<title>";
		// echo "Home";
		// echo "</title>";
	// echo "</head>";
	// echo "<body>";
	// // load();
		// // bring in a bunch of info here	
			// echo "Future posts will show here";
			// "This is the home page";
		
	// echo "</body>";
// echo "</html>";
?>