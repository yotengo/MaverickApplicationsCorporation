<?php
require("../Controller.php");
require("../View.php");

	$model= new Model();
	$view = new View();
	$control = new Controller();
	
	// if(empty($_COOKIE)){
	// above check seems to work. Use it in the rest of the site
		 // echo "<p>logged in as nobody...</p>";
		 // $view->displayLoginSub();// gives an error...probably has to do with directories...
	// }
	
	// function post(){
		// $control = new Controller();
		// $control -> submitPost();
	// }
	
	
	echo "<html>".PHP_EOL;
	
	
	// echo $control->authCheck();
	// echo $_COOKIE;
		
	
	echo "<head>".PHP_EOL;
	echo "<script>".PHP_EOL;
	echo "function textareaLengthCheck() {".PHP_EOL;
	echo "	var textarea = document.getElementById('textarea');".PHP_EOL;
	echo "	var length = textarea.value.length;".PHP_EOL;
	echo "	var charactersLeft = 200 - length;".PHP_EOL;
	echo "	var count = document.getElementById('count');".PHP_EOL;
	echo "	if(charactersLeft<0){";
	echo "		charactersLeft=0;";
	echo "	}";
	echo "	count.innerHTML = \"Characters left: \" + charactersLeft;".PHP_EOL;
	echo "}".PHP_EOL;	
	echo "</script>".PHP_EOL;
	
		echo "<title>".PHP_EOL;
		echo "Make a Post".PHP_EOL;
		echo "</title>".PHP_EOL;
	echo "</head>".PHP_EOL;
	echo "<body>".PHP_EOL;
	echo "<p>";
	if(isset($_COOKIE['user'])){
		echo "Welcome: ".$_COOKIE['user'];
	}else{
		$view = new View();
		 $view->displayLoginSub();
	}
	if(empty($_COOKIE)){
	// above check seems to work. Use it in the rest of the site
		 echo "<p>logged in as nobody...</p>";
		// $view->displayLogin();
	}
	echo "</p>";
		// bring in a bunch of info here	
	// echo "Future posts will show here.<br/>".PHP_EOL;
	echo "This is the post page".PHP_EOL;
	
	echo "<form name=\"login\" action=\"temp.php\" method=\"post\" onsubmit=\"return true\">".PHP_EOL;

	echo "<textarea rows=\"4\" cols=\"50\" name=\"textarea\" id=\"textarea\" maxlength=\"200\">".PHP_EOL;
	echo "Type your post here. Max of 200 characters.".PHP_EOL;
	echo "</textarea>".PHP_EOL;
	echo "<script>";
	echo "textarea.addEventListener(\"keypress\", textareaLengthCheck, false);";
	echo "</script>";
	echo "<br/>".PHP_EOL;
	echo "<strong id=\"count\">Characters left: 200</strong>".PHP_EOL;
	// echo "<strong>character(s) left</strong>".PHP_EOL;
	echo "<br/>".PHP_EOL;
	
	// echo "<button type=\"button\" onclick=\"textareaLengthCheck()\" name=\"charCount\" value=\"false\" id=\"charCount\">".PHP_EOL;
	// echo "See Character Count".PHP_EOL;
	// echo "</button>".PHP_EOL;
	
	// echo "<br/>".PHP_EOL;
	
	echo "<button onclick=textAreaLengthCheck() type=\"s\" name=\"finalPost\" value=\"false\">".PHP_EOL;
	echo "Post".PHP_EOL;
	echo "</button>".PHP_EOL;
	echo "</form>".PHP_EOL;
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
?>