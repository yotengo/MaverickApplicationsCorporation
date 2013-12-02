<?php

require("../Controller.php");
require ("../View.php");

function displayAllUserResults(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();
	$meID=$model->getUserIdbyUsername($_COOKIE['user']);
	$userList=$model->getListOfAllUsers($meID);
	echo "<br/>";
	foreach ($userList as $key => $value){
		// echo "key: ".$key.PHP_EOL;
		echo "User: ".$value->getUserName();
		
		echo "<br/>Following: (1=yes,0=no) ".$model->checkIfFollowingUser($meID,$value->getUserID());
		
		echo "<br/>".PHP_EOL;
		
		echo "<form name=\"follow\" action=\"temp.php\" method=\"post\">".PHP_EOL;
		echo "<button type=\"submit\" name=\"followUser\" onclick=\"return true\" value=".$value->getUserID().">".PHP_EOL;
		echo "Follow/Unfollow".PHP_EOL;
		echo "</button>".PHP_EOL;
		echo "</form><br/>".PHP_EOL;
		
		
	}
}

/**
	 * This function creates a join table in the database for a user to follow another user.
	 * 
	 * @param this functions takes the user ids of the users to follow the other. In this case, userA is to follow userB.
	 * @return nothing to return
	 * @author Ryan
	 */
	
	//TESTED
	// function followUser($userIDA,$userIDB)



function displayAllHashtagResults(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();
	$hashtagList=$model->getListOfAllHashtags();
	echo "<br/>";
	foreach ($hashtagList as $key => $value){
		// echo "key: ".$key.PHP_EOL;
		echo "Hashtag: ".$value->getHashtag()."<br/>".PHP_EOL;
		
		
		$meID=$model->getUserIdbyUsername($_COOKIE['user']);
		echo "Following: (1=yes,0=no) ".$model->checkIfFollowingHashtag($meID,$value->getHashtagID());
		
		echo "<br/>".PHP_EOL;
		
		echo "<form name=\"follow\" action=\"temp.php\" method=\"post\">".PHP_EOL;
		echo "<button type=\"submit\" name=\"followHashtag\" onclick=\"return true\" value=".$value->getHashtagID().">".PHP_EOL;
		echo "Follow/Unfollow".PHP_EOL;
		echo "</button>".PHP_EOL;
		echo "</form><br/>".PHP_EOL;
	}
}

function displaySelectUsers(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();

	$users=$model->searchForUser($_COOKIE['searchTerm']);
	if(empty($users)){
		echo "<br/>";
		echo "No matching users";
	}
	foreach ($users as $key => $value){
		// echo "key: ".$key.PHP_EOL;
		echo "<br/>";
		echo "User: ".$value->getUserName()." ".$value->getFirstName()." ".$value->getLastName()."<br/>".PHP_EOL;
		
		
		$meID=$model->getUserIdbyUsername($_COOKIE['user']);
		echo "Following: (1=yes,0=no) ".$model->checkIfFollowingUser($meID,$value->getUserID());
		
		echo "<br/>".PHP_EOL;
		
		echo "<form name=\"follow\" action=\"temp.php\" method=\"post\">".PHP_EOL;
		echo "<button type=\"submit\" name=\"followUser\" onclick=\"return true\" value=".$value->getUserID().">".PHP_EOL;
		echo "Follow/Unfollow".PHP_EOL;
		echo "</button>".PHP_EOL;
		echo "</form><br/>".PHP_EOL;
	}
	
}

function displaySelectHashtags(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();

	$postList=$model->getPostsByHashtag($_COOKIE['searchTerm']);
	
	if(empty($postList)){
		echo "<br/>";
		echo "No posts containing the search term";
	}
	echo "<br/>";
	foreach ($postList as $key => $value){
	echo "<br/>";
		$value->printPost();
		echo "<br/>";
		echo "<br/>";
	}
	
	// $hashtags=$model->searchForHashtag($_COOKIE['searchTerm']);
	
	// if(empty($hashtags)){
		// echo "<br/>";
		// echo "No matching hashtags";
	// }
	
	// foreach ($hashtags as $key => $value){
		// echo "key: ".$key.PHP_EOL;
		// echo "<br/>";
		// echo "Hashtag: ".$value->getHashtag()."<br/>".PHP_EOL;
		
		// $meID=$model->getUserIdbyUsername($_COOKIE['user']);
		// echo "Following: (1=yes,0=no) ".$model->checkIfFollowingHashtag($meID,$value->getHashtagID());
		
		// echo "<br/>".PHP_EOL;
		
		// echo "<form name=\"follow\" action=\"temp.php\" method=\"post\">".PHP_EOL;
		// echo "<button type=\"submit\" name=\"followHashtag\" onclick=\"return true\" value=".$value->getHashtagID().">".PHP_EOL;
		// echo "Follow/Unfollow".PHP_EOL;
		// echo "</button>".PHP_EOL;
		// echo "</form><br/>".PHP_EOL;
	// }
	
}


	echo "<html>".PHP_EOL;
	echo "<head>".PHP_EOL;
		echo "<title>".PHP_EOL;
		echo "Search Results".PHP_EOL;
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
				// echo "		<option value=\"fname\">First Name</option>".PHP_EOL;
				// echo "		<option value=\"lname\">Last Name</option>".PHP_EOL;
				// echo "		<option value=\"uname\">Username</option>".PHP_EOL;
				echo "		<option value=\"htag\">Hashtag</option>".PHP_EOL;
				echo "	</select>".PHP_EOL;
				echo "	<button type=\"submit\" onclick=\"formSubmit()\" value=\"searchSite2\" name=\"searchSite\">".PHP_EOL;
				echo "Search".PHP_EOL;
				echo "	</button>".PHP_EOL;
				echo "	</form>".PHP_EOL;
				echo "</p>".PHP_EOL;
				echo "Back to <a href=home2.php>home</a>".PHP_EOL;
				
		if($_COOKIE['type']==="user"){		
			displayAllUserResults();
		}else if($_COOKIE['type']==="htag"){
			displayAllHashtagResults();
		}else if($_COOKIE['type']==="limiteduser"){
			displaySelectUsers();
		}else if($_COOKIE['type']==="limitedhtag"){
			displaySelectHashtags();
		}
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;
?>