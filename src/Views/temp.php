<?php
require("../Controller.php");
require("../View.php");

//google this: how to send a link by email using php


function userlogin(){	
		$control = new Controller();
		$view 	= new View();
		$model = new Model();
		if(isset($_POST['username'])&&isset($_POST['password'])&&$_POST['username']!=""&&$_POST['password']!=""){
			if(!empty($_POST)){
				$control -> login();
			}
//			$view -> displayHeader("views/home.php");
		}else if(isset($_POST['register'])){
			$view-> displayPageSub("create.php");
			// unset($_POST);
			// return false;
			//echo "<p> test message </p>";
		}else if(isset($_POST['forgotpass'])){
			$view-> displayPageSub("forgot.php");
			// unset($_POST);
			// return false;
			//echo "<p> test message </p>";
		}else{
			echo "<script>alert(\"Enter your information in both fields.\")</script>";
			$view->displayLoginSub();
			
		}
}


function userCreate(){	
	$control = new Controller();
		$view 	= new View();
		$model = new Model();
	
		if((($_POST['password'])==="")&&(($_POST['password2'])==="")){
			echo "<script>alert(\"Password fields are required.\")</script>";
			$view -> displayPageSub("create.php");
			return false;
		}else if(strlen($_POST['password'])<8){ 
			echo "<script>alert(\"Password must be a least 8 characters long.\")</script>";
			$view -> displayPageSub("create.php");
			return false;
		}else if(strcmp($_POST['password'],$_POST['password2'])===0){
			//check if the username is available
			if ($model->checkUsernameAvailability($_POST['username']) == 0)
			{
				echo "<script>alert(\"Sorry. That username is taken. Try adding (more) numbers to the end\")</script>";
				$view->displayPageSub("create.php");
				return false;
			}
		}
		else{
				// echo "Passwords don't match.(1)";
				echo "<script>alert(\"passwords don't match\")</script>";
				$view-> displayPageSub("create.php");
				// echo "Passwords don't match.(2)";
				// echo "<script>alert(\"passwords don't match(4)\")</script>";
				return false;
			 // if they don't match, return false
				// echo "<script>alert(\"passwords don't match\")</script>";
		}
		
		
		if(($_POST['username']==="")||($_POST['password']==="")||($_POST['email']==="")
		||($_POST['firstname']==="")||($_POST['lastname']==="")||($_POST['password2']==="")){
			echo "<script>alert(\"All fields are required.\")</script>";
			$view -> displayPageSub("create.php");
		}else if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])
		&&isset($_POST['firstname'])&&isset($_POST['lastname'])&&isset($_POST['password2'])){
			if ($model->checkUsernameAvailability($_POST['username']) == 1){


			
				$token = md5($_POST['email'].time());//testing
				if(mail($_POST['email'], 'Welcome to THIN(1)', $token)===true){
					echo "<script>alert(\"Account successfully created. Check the provided email for a link(1).\")</script>";
				}else{
					echo "<script>alert(\"Something went wrong.\")</script>";
				}
				echo "<script>alert(\"Account successfully created. Check the provided email for a link(1).\")</script>";


				
				$control -> signUp();//if username is available, make the account
				
				// $token = md5($_POST['email'].time());//testing	
				// mail($_POST['email'], 'Welcome to THIN(1)', $token);
				// echo "<script>alert(\"Account successfully created. Check the provided email for a link(2).\")</script>";
			
				$view -> displayLogin();
			}
		}else{
			$view -> displayPageSub("create.php");
		}
}

function dispChangePassPage(){
		$control = new Controller();
		$view 	= new View();
		$model = new Model();
		$view-> displayPageSub("changepass.php");
}

function dispfolHashPage(){
		$control = new Controller();
		$view 	= new View();
		$model = new Model();
		$view-> displayPageSub("folHashtags.php");
}

function forgotpass(){	
	$control = new Controller();
		$view 	= new View();
		$model = new Model();
	
		 if(($_POST['email'])===""){
			$view -> displayPageSub("forgot.php");
			return false;
		}else if(isset($_POST['email'])){
			$control -> forgotPass();
			$view -> displayLogin();
		}
		else{
			$view -> displayPageSub("forgot.php");
		}		
}		
function changePassword(){	
	$control = new Controller();
		$view 	= new View();
		$model = new Model();
	
		 if((($_POST['NewPass'])==="")&&(($_POST['NewPass2'])==="")){
			$view -> displayPageSub("changepass.php");
			return false;
		}else if(strlen($_POST['NewPass'])<8){ 
			echo "<script>alert(\"Password must be a least 8 characters long.\")</script>";
			$view -> displayPageSub("changepass.php");
			return false;
		}else if(strcmp($_POST['NewPass'],$_POST['NewPass2'])===0){
				// continue
		}else{
				$view-> displayPageSub("changepass.php");
				return false;
			 // if they don't match, return false
				// echo "<script>alert(\"passwords don't match\")</script>";
		}
		
		if(($_POST['Password']==="")||($_POST['NewPass']==="")||($_POST['NewPass2']==="")){
			$view -> displayPageSub("changepass.php");
		}else if(isset($_POST['Password'])&&isset($_POST['NewPass'])&&isset($_POST['NewPass2'])){
				$control -> changePass();
				$view -> displayLogin();
			}
		else{
			$view -> displayPageSub("changepass.php");
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

	
	if(($_POST['searchTerm']==="")&&($_POST['option']==="user")){
		$view->displayPageSub("searchResults.php");
		setcookie("type","user");
	}else if(($_POST['searchTerm']==="#")&&($_POST['option']==="htag")){
		$view->displayPageSub("searchResults.php");
		setcookie("type","htag");
	}else if($_POST['option']==="user"){
		setcookie("type","limiteduser");
		setcookie("searchTerm",$_POST['searchTerm']);
		$view->displayPageSub("searchResults.php");
	}else if(($_POST['option']==="htag")&&!($_POST['searchTerm']==="")){
		setcookie("type","limitedhtag");
		setcookie("searchTerm",substr($_POST['searchTerm'],1));
		$view->displayPageSub("searchResults.php");	
	}else if(($_POST['option']==="htag")&&($_POST['searchTerm']==="")){
		echo "Nothing matches that. If your trying to see all hashtags in the system enter a hashtag ('#') in the search box.<p>".PHP_EOL;
		echo "<a href=\"search.php\">Search again</a>";
		return false;
	}else{
		echo "No results to show. ";
		echo "<a href=\"search.php\">Search again</a>";
		return false;//for now...
	}
	//model-> searchForUser($username)
	
}


function likePost($postID){
		$control = new Controller();
		$view 	= new View();
		$model=new Model();
		$model->likePost($postID);
		$view->displayPageSub("home2.php");
	}

function followUser($userID){
		$control = new Controller();
		$view 	= new View();
		$model=new Model();
		
		// @return returns 1 if userA is following userB, 0 otherwise
		
		$meID=$model->getUserIdbyUsername($_COOKIE['user']);
		if($model->checkIfFollowingUser($meID,$userID)===0){//if I'm not following the user in question	
			$model->followUser($meID,$userID);
		}else if($model->checkIfFollowingUser($meID,$userID)===1){
			$model->unFollowUser($meID,$userID);
		}
		$view->displayPageSub("home2.php");

}

function followHashtag($hashtagID){
		$control = new Controller();
		$view 	= new View();
		$model=new Model();
		
		// @return returns 1 if userA is following userB, 0 otherwise
		
		$meID=$model->getUserIdbyUsername($_COOKIE['user']);
		if($model->checkIfFollowingHashtag($meID,$hashtagID)===0){//if I'm not following the htag in question	
			$model->followHashtag($meID,$hashtagID);
		}else if($model->checkIfFollowingHashtag($meID,$hashtagID)===1){
			$model->unFollowHashtag($meID,$hashtagID);
		}
		$view->displayPageSub("home2.php");
}



	if(isset($_POST['create'])){
		userCreate();
	}else if(isset($_POST['forgot'])){
		forgotpass();
	}else if(isset($_POST['makePost'])){
		post();
	}else if(isset($_POST['logoff'])){
		logoff();
	}else if(isset($_POST['finalPost'])){
		publishPost();
		setcookie('textarea', $_POST['textarea']);
		$model->makeHashtag();
	}else if(isset($_POST['searchSite'])){
		searchSite();
	}else if(isset($_POST['likePost'])){
		likePost($_POST['likePost']);
	}else if(isset($_POST['followUser'])){
		followUser($_POST['followUser']);
	}else if(isset($_POST['followHashtag'])){
		followHashtag($_POST['followHashtag']);
	}
	else if(isset($_POST['changepass'])){
		changePassword();
	}
	else if(isset($_POST['displaychangepass'])){
		dispChangePassPage();
	}
	else if(isset($_POST['displayhashtagfollowing'])){
		dispfolHashPage();
	}else if(isset($_POST['gohome'])){
		$view 	= new View();
		$view->displayPageSub("home2.php");
	}else{
		userlogin();
	}
	

	exit;
?>