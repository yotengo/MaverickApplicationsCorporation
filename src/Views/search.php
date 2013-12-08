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
	
	echo "<form name=\"login\" action=\"temp.php\" method=\"post\">".PHP_EOL;
echo "<button type=\"submit\" name=\"logoff\" onclick=\"return true\" value=\"Logout\" style=\"float: right;\">".PHP_EOL;
echo "Logout".PHP_EOL;
echo "</button>".PHP_EOL;
echo "</form>".PHP_EOL;
	
	echo "<p>".PHP_EOL;
				echo "	<form action=\"temp.php\" method=\"post\">".PHP_EOL;
				echo "	<input name=\"searchTerm\" type=\"text\">".PHP_EOL;
				echo "  <select name=\"option\">".PHP_EOL;
				echo "		<option value=\"user\">User</option>".PHP_EOL;
				echo "		<option value=\"htag\">Hashtag</option>".PHP_EOL;
				echo "	</select>".PHP_EOL;
				echo "	<button type=\"submit\" onclick=\"\" value=\"searchSite2\" name=\"searchSite\">".PHP_EOL;
				echo "Search".PHP_EOL;
				echo "	</button>".PHP_EOL;
				echo "	</form>".PHP_EOL;
				echo "</p>".PHP_EOL;
				echo "Back to <a href=home2.php>home</a>".PHP_EOL;
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
?>