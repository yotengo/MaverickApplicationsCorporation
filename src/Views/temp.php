<?php
require("../Controller.php");
require("../View.php");


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
		}else if(isset($_POST['forgotpw'])){
			$view-> displayPageSub("forgot.php");
			// unset($_POST);
			// return false;
			//echo "<p> test message </p>";
		}else{
		
			$view->displayLoginSub();
			
		}
}


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
function changePassword(){	
	$control = new Controller();
		$view 	= new View();
		$model = new Model();
	
		 if((($_POST['newpass'])==="")&&(($_POST['newpass2'])==="")){
			$view -> displayPageSub("changepass.php");
			return false;
		}else if(strcmp($_POST['newpass'],$_POST['newpass2'])===0){
				// continue
		}else{
				$view-> displayPageSub("changepass.php");
				return false;
			 // if they don't match, return false
				// echo "<script>alert(\"passwords don't match\")</script>";
		}
		
		if(($_POST['oldpass']==="")||($_POST['newpass']==="")||($_POST['newpass2']==="")){
			$view -> displayPageSub("changepass.php");
		}else if(isset($_POST['oldpass'])&&isset($_POST['newpass'])&&isset($_POST['newpass2'])){
				$control -> changePass();
				$view -> displayLogin();
			}
		}else{
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
}

function followHashtag($hashtagID){
		$control = new Controller();
		$view 	= new View();
		$model=new Model();
		
		// @return returns 1 if userA is following userB, 0 otherwise
		
		$meID=$model->getUserIdbyUsername($_COOKIE['user']);
		if($model->checkIfFollowingHashtag($meID,$hashtagID)===0){//if I'm not following the htag in question	
			$model->followHashtag($meID,$hashtagID);
		}else if($model->checkIfFollowingHashtag($meID,$userID)===1){
			$model->unFollowHashtag($meID,$hashtagID);
		}
}




	if(isset($_POST['create'])){
		userCreate();
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
	}else{
		userlogin();
	}
	
	
	// SQL testing****************
	// USE rcarlso;
// SHOW TABLES;
// SELECT * FROM Post;

	exit;
?>