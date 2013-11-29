<?php

require("../Controller.php");
require ("../View.php");

function displayAllUserResults(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();
	$userList=$model->getListOfAllUsers();
	echo "<br/>";
	foreach ($userList as $key => $value){
		// echo "key: ".$key.PHP_EOL;
		echo "User: ".$value->getUserName()."<br/>".PHP_EOL;
	}
}

function displayAllHashtagResults(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();
	$hashtagList=$model->getListOfAllHashtags();
	echo "<br/>";
	foreach ($hashtagList as $key => $value){
		// echo "key: ".$key.PHP_EOL;
		echo "Hashtag: ".$value->getHashtag()."<br/>".PHP_EOL;
	}
}


	echo "<html>".PHP_EOL;
	echo "<head>".PHP_EOL;
		echo "<title>".PHP_EOL;
		echo "Search Results".PHP_EOL;
		echo "</title>".PHP_EOL;
	echo "</head>".PHP_EOL;
	echo "<body>".PHP_EOL;
	
	
	

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
				
		if($_COOKIE['type']==="uname"){		
			displayAllUserResults();
		}else if($_COOKIE['type']==="htag"){
			displayAllHashtagResults();
		}
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
?>