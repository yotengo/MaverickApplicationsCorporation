<?php
require("../Controller.php");
require("../View.php");

	$model= new Model();
	$view = new View();
	$control = new Controller();
	
	echo "<html>".PHP_EOL;
	
	// echo $control->authCheck();
	// echo $_COOKIE;
	
	
	
	echo "<head>".PHP_EOL;
		echo "<title>".PHP_EOL;
		echo "Home".PHP_EOL;
		echo "</title>".PHP_EOL;
	echo "</head>".PHP_EOL;
	echo "<body>".PHP_EOL;
	echo "<p>";
	foreach ($_COOKIE as $key => $value){
		// echo "key: ".$key.PHP_EOL;
		echo "</p><p>Currently logged on as: ".$value.PHP_EOL;
	}
	if(empty($_COOKIE)){
	// above check seems to work. Use it in the rest of the site
		echo "<p>logged in as nobody...</p>";
	}
	 echo "</p>";
		// bring in a bunch of info here	
			echo "Future posts will show here.<br/>".PHP_EOL;
			echo "This is the home2 page".PHP_EOL;
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
?>