<?php

//require("../Model.php");
require("../Controller.php");
//require ("../View.php");
//resource: http://stackoverflow.com/questions/5968280/how-to-run-a-php-function-from-an-html-form
//<!--this will be the first page on the site that users will see-->
	//if(isset($_POST['register']){
		
	//}


	echo "<html>".PHP_EOL;
	echo "<head>".PHP_EOL;
	echo "	<title>".PHP_EOL;
	echo "	Login".PHP_EOL;
	echo "	</title>";//add eols on down
	echo "</head>";
	echo "<body>";
	echo "	<form name=\"login\" action=\"";
	
//	$control = new Controller();
//	$control -> login();
	
	echo "\" method=\"post\" onsubmit=\"return true\">";
	echo "		Username: <input type=\"text\" name=\"username\"><br>";
	echo "		Password: <input type=\"password\" name=\"password\"><br>";
	echo "		<button type=\"submit\" onclick=\"formSubmit()\" value=\"Submit form\">";
	echo "		Login";
	echo "		</button>";
	echo "		<button type=\"s\" name=\"register\" value=\"false\" onclick=\"return true\">";
	echo "		Create an Account";
	echo "		</button>";

	echo "	<p>";
	echo "		<button type=\"s\" name=\"forgotpw\" value=\"false\" onclick=\"return true\">";
	//<!--//on click end-->
			
	echo "		Forgot Password?";
	echo "		</button>";
	echo "	</p>";
			echo "	</form> ";
		
	//		echo "Php is working.";
		
		
	echo "</body>";
echo "</html>";

?>