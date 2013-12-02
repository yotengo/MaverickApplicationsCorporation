<?php
require("Model.php");

class Index{
        private $indexVal;
        
        function __construct(){
		//Index allows control of the flow from urls/functions        
            $this->indexVal = array(
            //Format is indexVal => function/page
                "home" => "contPage",
                "login" => "login",
                "logout" => "logout",
                "signup" => "signUp",
                "feed" => "feed",
				"post" => "submitPost"
                );
        }
        //Returns the value of the associate indexVal
        public function searchIndex($query){
            return $this->indexVal[$query];
        }
}
class Controller{        
        private $model;
        private $index;
        
        function __construct(){
            //initialize private variables
            $this->model = new Model();
            $this->index = new Index();
			//For future functionality of Twitter.com/profiles/Steve                
            $multparams = false;
//			$page = $_GET['page'];
    //        $loading = $this->index->searchIndex($page);
		//	$this->$loading($multparams);
        }        
 
		/**
		* Views are elements of pages such as the header, body, and footer
		* This function loads a view and the data associated with it
		* @param takes in filename of view and array of data
		* @author Steve
		*/
		//TESTED
		private function loadView($view, $data){
            if(is_array($data)){
                extract($data);
            }
            require("Views/" . $view . ".php");
        }

		/**
		* Pages are made up of views(Will incorporate more views as they as designed(.ie header and footer)
		* @param takes $user object, view filename, array of data to be loaded on page
		* @author Steve
		*/
		//TESTED
        private function loadPage($user, $view, $data){
			$this->loadView($view, array('User' => $user));
		}


		/**
		* Function checks for the cookie associated with login and returns the user's data
		* This function is called when user's data needs to be passed to a method in the model
		* @return user array or false if cookie is not set
		* @author Steve
		*/
		//TESTED
		function authCheck(){
			if(isset($_COOKIE['user'])){
				// print_r($this->model->cookieCheck($_COOKIE['user']));
				return $this->model->cookieCheck($_COOKIE['user']);
			}
			else{
				return false;
			}
        }
        
		/**
		* Function will redirect to another page
		* @param takes in a (String) url
		* @author Steve
		*/
		//TESTED
        private function redirect($url){
			header("Location: /" . $url);
		}
        
		/**
		* This function is used to check that login was successful and redirect the user to their home page.  
		* @author Steve
		*/
		//TESTED 
		private function contPage(){
			$user = $this->authCheck();
			if($user === true){
                $this->redirect("feed");
            }
			else{
				$this->loadPage($user, "login", array());
			}
		}

		/**
		* This function passes the signup information to the model so that it can be entered into the database.  
		* Redirects the user to proper page if the information is correct
		* @author Steve
		*/
		//TESTED
	  function signUp(){
		if(isset($_POST['create'])){
            $signup = array(
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname']
            );
            // $register = $this->model->registerUser($signup);
            if($this->model->registerUser($signup) === true){
                $this->redirect("views/home.php");
            }
            else{
                $this->redirect("views/createreject.php");
            }
		}
	}
    
		/**
		* Passes the login information to the controller
		* Handles forgot password and register buttons
		* @author Steve
		*/
		//TESTED
		function login(){
			if(isset($_COOKIE['lockout'])){
				$this->redirect("views/lockout.php");
				return false;
			}
		
            $loginInfo = array(
                'username' => $_POST['username'],
                'password' => $_POST['password']
            );
            if(isset($_POST['register'])){
				$user="";
				$this->redirect("views/create.php");
				//  $this->loadPage($user, 'create', array());
            }
			else if(isset($_POST['forgotpw'])){
				$this->redirect("views/forgot.php");
			}
            else if($this->model->attemptLogin($loginInfo) === true){
				// $this->redirect("feed");
				$this->redirect("views/home.php");
			}
			else{
				
				setcookie('loginattempts', intval($_COOKIE['loginattempts'])+1);
				if(intval($_COOKIE['loginattempts'])>=5){
					setcookie('lockout', 1, time()+60);
				}
				$this->redirect("views/reject.php");
			}
        }
		function changePass(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("views/changepass.php");
			}else{
				if(isset($_POST['change'])){
					$pass = $_POST['newpass'];
					$oldpass = $_POST['oldpass'];
					if($this->model->changePass($oldpass, $pass,$user->UserID) === true){
						$this->logout();
						$this->redirect("views/login.php");
					}
					else{
						$this->redirect("views/changepass.php");
					}
				}
			}			
		
	}
		}
         
		/**
		* Function called logout in the model and redirects to the login page
		* @author Steve
		*/
		//TESTED
		function logout(){
			$this->model->logoutUser($_COOKIE['user']);
			// $this->redirect("views/");
		}
	
		/**
		* Takes post information from view and creates Post object that
		* is passed to the model
		* @author Steve
		*/
		//TESTED
		function submitPost(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("views/login.php");
			}else{
				$postText = $_POST['textarea'];
				$userID = $user->UserID;
				$timePosted = new DateTime('NOW',new DateTimeZone('America/Chicago'));				
				$post = new Post(0,$userID,$postText,$timePosted,0);
				// if(strlen($postText) > 200){
					// $this->redirect("feed");
					// // Need to add an error message here
				// }
				// else{
					$this->model->post($post);
					$this->redirect("views/home2.php");
				// }
			}
        
		}
	
		/**
		* Loads up the main page, gets the array of Posts from the model to display on the page.
		* @author Steve
		*/
		//TESTED
	private function feed(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$postfeed = $this->model->getMainPagePosts($user->UserID);           
				$this->loadPage($user, "feedpage", array('User' => $user, "postfeed" => $postfeed));
			}
		}
		/**
		* Loads up the page that shows a list of all hashtags
		* @author Steve
		*/
		//NOT TESTED
		private function hashList(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$hashfeed = $this->model->getListofAllHashtags($user->UserID);           
				$this->loadPage($user, "hashlist", array('User' => $user, "hashfeed" => $hashfeed));
			}
		}
		/**
		*  Loads up the page that shows a list of all users
		* @author Steve
		*/
		//NOT TESTED
		private function userList(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$userfeed = $this->model->getListofAllUsers($user->UserID);           
				$this->loadPage($user, "userlist", array('User' => $user, "userfeed" => $userfeed));
			}
		}
		
		/**
		* Takes the information from search bar and calls appropriate function from model
		* First checks for just the #, then checks if they are searching for a hashtag, then defaults to searching  by user.  
		* @author Steve
		*/
		//NOT TESTED
		private function search(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$searchTerm = $_POST['search'];
				if($searchTerm == '#'){
					$hashfeed = $this->model->getListofAllHashtags($user->UserID);           
					$this->loadPage($user, "hashlist", array('User' => $user, "hashfeed" => $hashfeed));
				}
				else{
					$check = checkIfHashtagExists($searchTerm);
					if($check == 1){
						$posts = getPostsByHashtag($searchTerm);
						$this->loadPage($user, "hashSearch", array('User' => $user, "hashPosts" => $posts));
					}
					else{
						$users = searchForUser($searchTerm,$user->UserID);
						if(!($users->isEmpty())){							
							$this->loadPage($user, "userSearch", array('User' => $user, "userList" => $users));					
						}
						else{
							//need to load a blank page saying no results were returned
						}
					}

				}
			}
		}
		
		/**
		* Calls the like function in the model on the appropriate postID
		* @param takes in a (String) postID
		* @author Steve
		*/
		//NOT TESTED
		private function like($id){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$this->model->like($id);
			}
		}
		
		/**
		* Calls model function to follow using user-id and target-user-id
		* @param takes in a (String) target-user-id
		* @author Steve
		*/
		//NOT TESTED
		private function follow($id){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$this->model->followUser($user, $id);
			}
		}
		/**
		* Calls model function to unfollow using user-id and target-user-id
		* @param takes in a (String) target-user-id
		* @author Steve
		*/
		//NOT TESTED
		private function unfollow($id){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$this->model->unFollowUser($user, $id);
			}
		}

		/**
		* View page should have a drop down menu to select sort criteria.  
		* Should associate each option with a number. 
		* (Username:1, Hashtag:2, Likes:3)
		* Sorts the posts on the user's homepage by username, hashtag, likes, or time.  
		* Defaults to time.  
		* @author Steve
		*/
		//NOT TESTED
/*		private function sort(){
			$user = $this->authCheck();
			$sortSelect = $_POST['sort'];
			if($sortSelect == 1){
				$postfeed = $this->model->getMainPagePosts($user->UserID); 
				$sortUserName = $this->model->sortPostsByUsername($postfeed);
				$this->loadPage($user, "feedpage", array('User' => $user, "postfeed" => $sortUserName));
			}
			else if($sortSelect == 2){
				$postfeed = $this->model->getMainPagePosts($user->UserID);
				$sortHash = $this->model->sortPostsByHashtag($postfeed);
				$this->loadPage($user, "feedpage", array('User' => $user, "postfeed" => $sortHash));
			}
			else if($sortSelect == 3){
				$postfeed = $this->model->getMainPagePosts($user->UserID);  
				$sortLikes = $this->model->sortPostsByLikes($postfeed);
				$this->loadPage($user, "feedpage", array('User' => $user, "postfeed" => $sortLikes));
			}
			else{
				$postfeed = $this->model->getMainPagePosts($user->UserID);           
				$this->loadPage($user, "feedpage", array('User' => $user, "postfeed" => $postfeed));
			}
		}
*/		
}		