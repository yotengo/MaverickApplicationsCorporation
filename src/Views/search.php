<?php

	echo "<html>".PHP_EOL;
	echo "<head>".PHP_EOL;
		echo "<title>".PHP_EOL;
		echo "Search".PHP_EOL;
		echo "</title>".PHP_EOL;
	echo "</head>".PHP_EOL;
	echo "<body>".PHP_EOL;
	if(isset($_COOKIE['user'])){
		echo "Welcome: ".$_COOKIE['user'].PHP_EOL;
	}else{
		$view = new View();
		 $view->displayLoginSub();
	}
	echo "<p>".PHP_EOL;
				echo "	<form action=\"temp.php\" method=\"post\">".PHP_EOL;
				echo "	<input name=\"searchTerm\" type=\"text\">".PHP_EOL;
				echo "  <select name=\"option\">".PHP_EOL;
				echo "		<option value=\"fname\">First Name</option>".PHP_EOL;
				echo "		<option value=\"lname\">Last Name</option>".PHP_EOL;
				echo "		<option value=\"uname\">Username</option>".PHP_EOL;
				echo "		<option value=\"htag\">Hashtag</option>".PHP_EOL;
				echo "	</select>".PHP_EOL;
				echo "	<button type=\"submit\" onclick=\"formSubmit()\" value=\"searchSite2\" name=\"searchSite\">".PHP_EOL;
				echo "Search".PHP_EOL;
				echo "	</button>".PHP_EOL;
				echo "	</form>".PHP_EOL;
				echo "</p>".PHP_EOL;
				echo "Back to <a href=home2.php>home</a>".PHP_EOL;
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
?>