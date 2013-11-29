<?php
require("../Controller.php");
require("../View.php");

	$model= new Model();
	$view = new View();
	$control = new Controller();
	
	function prePost(){
		$control = new Controller();
		$view = new View();
		$view -> displayPageSub("post.php");
	}
	
	if(empty($_COOKIE)){
	// above check seems to work. Use it in the rest of the site
		 // echo "<p>logged in as nobody...</p>";
		 $view->displayLoginSub();
	}
	
	if(isset($_COOKIE['user'])){
		echo "Welcome: ".$_COOKIE['user'];
	}else{
		$view = new View();
		 $view->displayLoginSub();
	}
	
	// function post(){
	// $control = new Controller();
	// $control -> 
	// }
	
	// echo $control->authCheck();
	// echo $_COOKIE;
	
	echo "<html>".PHP_EOL;
	
	echo "<head>".PHP_EOL;
		echo "<title>".PHP_EOL;
		echo "Home".PHP_EOL;
		echo "</title>".PHP_EOL;
	echo "</head>".PHP_EOL;
	echo "<body>".PHP_EOL;
	
	echo "<form name=\"login\" action=\"search.php\" method=\"post\" onsubmit=\"return true\">".PHP_EOL;
	echo "		<button type=\"submit\" name=\"searchPage\" onclick=\"\" value=\"Submit form\">".PHP_EOL;
	echo "		Search".PHP_EOL;
	echo "		</button>".PHP_EOL;
	echo "</form>";
	
	echo "<p>";
	// foreach ($_COOKIE as $key => $value){
		// // echo "key: ".$key.PHP_EOL;
		// echo "</p><p>Welcome: ".$value.PHP_EOL;
	// }
	
	
	if(empty($_COOKIE)){
	// above check seems to work. Use it in the rest of the site
		 echo "<p>logged in as nobody...</p>";
		$view->displayLogin();
	}
	
	// if(isset($_COOKIE['user'])){
		// echo "Welcome: ".$_COOKIE['user'];
	// }else{
		// $view = new View();
		 // $view->displayLoginSub();
	// }
	
	echo "</p>";
		// bring in a bunch of info here	
	echo "Future posts will show here.<br/>".PHP_EOL;
	echo "This is the home2 page<br/>".PHP_EOL;
	
	echo "		<form action=\"temp.php\" method=\"post\">".PHP_EOL;
	echo "<button onclick=\"temp.php\" type=\"s\" name=\"makePost\" value=\"false\">".PHP_EOL;
	echo "Make a Post".PHP_EOL;
	echo "</button>".PHP_EOL;
	echo "</form>".PHP_EOL;	
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
?>