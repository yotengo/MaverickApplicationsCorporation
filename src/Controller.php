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
	
		private function submitPost(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
				$postText = $_POST['text'];
				$userID = $user->UserID;
				$timePosted = new DateTime('NOW',new DateTimeZone('America/Chicago'));				
				$post = new Post(0,$userID,$postText,$timePosted,0);
				if(strlen($postText) > 140){
					$this->redirect("feed");
					//Need to add an error message here
				}
				else{
					$this->model->post($post);
					$this->redirect("feed");
				}
			}
        
		}
	
		private function feed(){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("home");
			}
			else{
//          	$postFeed = $this->model->getMainPaigePosts($user->getID());           
//				$this->loadPage($user, "feedpage", array('User' => $user, "messages" => $postFeed));
				$this->loadPage($user, "feedpage", array('User' => $user));
			}
		}
}		