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
		//View is an element of a page        
        private function loadView($view, $data){
            if(is_array($data)){
                extract($data);
            }
            require("Views/" . $view . ".php");
        }
		//Pages are made up of views(Will incorporate more views as they as designed(.ie
		// header and footer.
        private function loadPage($user, $view, $data){
			$this->loadView($view, array('User' => $user));
		}

        // private 
		function authCheck(){
			if(isset($_COOKIE['user'])){
				// print_r($this->model->cookieCheck($_COOKIE['user']));
				return $this->model->cookieCheck($_COOKIE['user']);
			}
			else{
				return false;
			}
        }
        
        private function redirect($url){
			header("Location: /" . $url);
		}
        
        private function contPage(){
			$user = $this->authCheck();
			if($user === true){
                $this->redirect("feed");
            }
			else{
				$this->loadPage($user, "login", array());
			}
		}

      //  private 
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
    
		//private 
		function login(){
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
				$this->redirect("views/reject.php");
			}
        }
        
        // private 
		function logout(){
			$this->model->logoutUser($_COOKIE['user']);
			// $this->redirect("views/");
		}
	
		// private 
		function submitPost(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("views/login.php");
			}else{
				$postText = $_POST['textarea'];
				$userID = $user->UserID;
				$timePosted = new DateTime('NOW',new DateTimeZone('America/Chicago'));				
				$post = new Post(0,$userID,$postText,$timePosted,0,$user->Username,$user->FirstName);
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
		//For displaying list of all hashtags
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
		//For displaying list of all users
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
		
		//For displaying pages from searching
		private function search(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$searchTerm = $_POST['search'];
				if(searchSelect == '#'){
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
		
		private function like($id){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$this->model->like($id);
			}
		}
		private function follow($id){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$this->model->followUser($user, $id);
			}
		}
		private function unfollow($id){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$this->model->unFollowUser($user, $id);
			}
		}		
}		