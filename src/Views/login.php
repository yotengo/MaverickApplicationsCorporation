<?php

//require("../Model.php");
require("../Controller.php");
require ("../View.php");
//resource: http://stackoverflow.com/questions/5968280/how-to-run-a-php-function-from-an-html-form
//<!--this will be the first page on the site that users will see-->
	$control = new Controller();
	$view 	= new View();
	$model = new Model();
	function userlogin(){	
		$control = new Controller();
		$view 	= new View();
		$model = new Model();
		if(isset($_POST['username'])&&isset($_POST['password'])){
			$control -> login();
//			$view -> displayHeader("views/home.php");
		}else{
			// unset($_POST);
			return false;
			//echo "<p> test message </p>";
		}
	}

	echo "<html>".PHP_EOL;
	echo "<head>".PHP_EOL;
	echo "	<title>".PHP_EOL;
	echo "	Login".PHP_EOL;
	echo "	</title>".PHP_EOL;
	echo "</head>".PHP_EOL;
	echo "<body>".PHP_EOL;
	echo "<form name=\"login\" action=\"";
	//userlogin();
	echo "\" method=\"post\" onsubmit=\"return true\">".PHP_EOL;
	echo "		Username: <input type=\"text\" name=\"username\"><br>".PHP_EOL;
	echo "		Password: <input type=\"password\" name=\"password\"><br>".PHP_EOL;
	
	echo "		<button type=\"submit\" name=\"login\" onclick=\"";
	userlogin();
	echo "\" value=\"Submit form\">".PHP_EOL;
	echo "		Login".PHP_EOL;
	echo "		</button>".PHP_EOL;
	
	echo "		<button type=\"s\" name=\"register\" value=\"false\" onclick=\"return true\">".PHP_EOL;
	echo "		Create an Account".PHP_EOL;
	echo "		</button>".PHP_EOL;

	echo "	<p>".PHP_EOL;
	
	
	echo "		<button type=\"s\" name=\"forgotpw\" value=\"false\" onclick=\"return true\">".PHP_EOL;
	//<!--//on click end-->		
	echo "		Forgot Password?".PHP_EOL;
	echo "		</button>".PHP_EOL;
	echo "	</p>".PHP_EOL;
	echo "	</form> ".PHP_EOL;		
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;

?>