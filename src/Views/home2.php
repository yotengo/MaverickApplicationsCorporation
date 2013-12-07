<?php
require("../Controller.php");
require("../View.php");


	$model= new Model();
	$view = new View();
	$control = new Controller();
	
	// function prePost(){
		// $control = new Controller();
		// $view = new View();
		// $view -> displayPageSub("post.php");
	// }
	
	function pagePosts(){
		$model= new Model();
		$view = new View();
		$control = new Controller();
		
		$userId=$model->getUserIdbyUsername($_COOKIE['user']);
		$posts=$model->getMainPagePosts($userId);
		// echo "Your userID is: ".$userId."<br/>";
		// print_r($model->makeHashtag());
		// print_r($posts);
		echo "<br/>";
		// if(isset($_COOKIE['ids'])){
			// print_r($_COOKIE['ids']);
			// echo "ids set";
			// echo $_COOKIE['ids'];
		// }else{
			// echo "Cookie for ids not set";
		// }
		
		echo "<br/>";
		
		if(empty($posts)){
			echo "No posts to show. Make a post or follow users for posts to show up here.";
		}
		foreach($posts as $key=>$value){
			if(is_object($value)){
				$value->printPost();
				echo "<br/>";
				// echo "HTML code here for like, etc";
				
				echo "<form name=\"likepost\" action=\"temp.php\" method=\"post\" onsubmit=\"return true\">".PHP_EOL;
				echo "		<button type=\"submit\" name=\"likePost\" onclick=\"\" value=".$value->getPostID().">".PHP_EOL;
				echo "		Like".PHP_EOL;
				echo "		</button>".PHP_EOL;
				echo "</form>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
			}else{
				// echo "This post is not an object. ".$value."<br/>".PHP_EOL;
				// echo "<br/>";
				// echo "<br/>";
				// echo "<br/>";
			}
		}
	}
	
	
	
	
	
	if(empty($_COOKIE)){
	// above check seems to work. Use it in the rest of the site
		 // echo "<p>logged in as nobody...</p>";
		 $view->displayLoginSub();
	}
	
	if(isset($_COOKIE['user'])){
	// echo "<h1>THIN</h1><br/>";
		echo "Welcome to THIN, ".$_COOKIE['user'];
	}else{
		$view = new View();
		 $view->displayLoginSub();
	}
	
	
//makeHashtag();
	
	echo "<form name=\"login\" action=\"temp.php\" method=\"post\">".PHP_EOL;
	echo "<button type=\"submit\" name=\"logoff\" onclick=\"return true\" value=\"Logout\" style=\"float: right;\">".PHP_EOL;
	echo "Logout".PHP_EOL;
	echo "</button>".PHP_EOL;
	// echo "</form>".PHP_EOL;
	// echo "<form action=\"temp.php\" method=\"post\">".PHP_EOL;
	echo "<button type=\"submit\" name=\"displaychangepass\" onclick=\"return true\" value=\"displaychangepass\" style=\"float: right;\">".PHP_EOL;
	echo "Change Password".PHP_EOL;
	echo "</button>".PHP_EOL;
	// echo "</form>".PHP_EOL;
	// echo "<form action=\"temp.php\" method=\"post\">".PHP_EOL;
	echo "<button type=\"submit\" name=\"displayhashtagfollowing\" onclick=\"return true\" value=\"displayhashtagfollowing\" style=\"float: right;\">".PHP_EOL;
	echo "Your Hashtags".PHP_EOL;
	echo "</button>".PHP_EOL;
	echo "</form>".PHP_EOL;
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
	
	echo "<form name=\"search\" action=\"search.php\" method=\"post\" onsubmit=\"return true\">".PHP_EOL;
	echo "		<button type=\"submit\" name=\"searchPage\" onclick=\"\" value=\"Submit form\">".PHP_EOL;
	echo "		Search".PHP_EOL;
	echo "		</button>".PHP_EOL;
	echo "</form>";
	
	// echo "<p>";
	// foreach ($_COOKIE as $key => $value){
		// // echo "key: ".$key.PHP_EOL;
		// echo "</p><p>Welcome: ".$value.PHP_EOL;
	// }
	
	echo "		<form action=\"temp.php\" method=\"post\">".PHP_EOL;
	echo "<button onclick=\"temp.php\" type=\"s\" name=\"makePost\" value=\"false\">".PHP_EOL;
	echo "Make a Post".PHP_EOL;
	echo "</button>".PHP_EOL;
	echo "</form>".PHP_EOL;	
	
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
	// echo "Future posts will show here.<br/>".PHP_EOL;
	pagePosts();
	// echo "<br/>This is the home2 page<br/>".PHP_EOL;
	
	
	
		
	echo "</body>".PHP_EOL;
echo "</html>".PHP_EOL;



?>