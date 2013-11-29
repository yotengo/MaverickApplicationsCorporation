<?php
require("../Controller.php");
require("../View.php");



function userCreate(){	
	$control = new Controller();
		$view 	= new View();
		$model = new Model();
	
		 if((($_POST['password'])==="")&&(($_POST['password2'])==="")){
			$view -> displayPageSub("create.php");
			return false;
		}else if(strcmp($_POST['password'],$_POST['password2'])===0){
				// continue
		}else{
				$view-> displayPageSub("create.php");
				return false;
			 // if they don't match, return false
				// echo "<script>alert(\"passwords don't match\")</script>";
		}
		
		
		if(($_POST['username']==="")||($_POST['password']==="")||($_POST['email']==="")
		||($_POST['firstname']==="")||($_POST['lastname']==="")||($_POST['password2']==="")){
			$view -> displayPageSub("create.php");
		}else if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])
		&&isset($_POST['firstname'])&&isset($_POST['lastname'])&&isset($_POST['password2'])){
			$control -> signUp();
			
			$view -> displayLogin();
		}else{
			$view -> displayPageSub("create.php");
		}
}

function post(){
	$control = new Controller();
		$view 	= new View();
		$model = new Model();
		if(isset($_POST['makePost'])){
			if($control->authCheck()===false){
				$view->displayLoginSub();
			}else{
				$view->displayPageSub("post.php");
			
			}
			
		}
}

function logoff(){
	$control = new Controller();
		$view 	= new View();
		$model = new Model();
		if(isset($_POST['logoff'])){
			$control->logout();
			$view->displayLoginSub();
		}
}

function publishPost(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();
	
	$control->submitPost();
	
}

function searchSite(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();

	if(($_POST['searchTerm']==="")&&($_POST['option']==="uname")){
		// $userList=$model->getListOfAllUsers();
		// foreach ($userList as $key => $value){
		// // echo "key: ".$key.PHP_EOL;
		// echo "</p><p>User: ".$value.PHP_EOL;
		$view->displayPageSub("searchResults.php");
		setcookie("type","uname");
	}else if(($_POST['searchTerm']==="")&&($_POST['option']==="htag")){
		$view->displayPageSub("searchResults.php");
		setcookie("type","htag");
	}else{
		echo "No results to show.";
		echo "<a href=\"search.php\">Search again</a>";
		return false;//for now...
	}
	//model-> searchForUser($username)
	
}

function makeHashtag(){
	$control = new Controller();
	$view 	= new View();
	$model = new Model();
	
	
	$postText = $_POST['textarea'];
	$hashTagtext="";
	$make=false;
	for($i=0;$i<strlen($postText);$i++){
		if($postText[$i]==='#'){
			$make=true;
			// $hashTagtext=$hashTagtext.postText.charAt(i);
		}else if($postText[$i]===' '){
			if($make===true){
				$hashTag = new Hashtag(0,$hashTagtext);
				$model->createHashtag($hashTag);
				$make=false;
			}
		}else if($make===true){
			$hashTagtext.=$postText[$i];
		}
	}
	
	// $model->createHashtag();
}




	if(isset($_POST['create'])){
		userCreate();
	}else if(isset($_POST['makePost'])){
		post();
	}else if(isset($_POST['logoff'])){
		logoff();
	}else if(isset($_POST['finalPost'])){
		publishPost();
		makeHashtag();
	}else if(isset($_POST['searchSite'])){
		searchSite();
	}
	
	
	// SQL testing****************
	// USE rcarlso;
// SHOW TABLES;
// SELECT * FROM Post;

	exit;
?>