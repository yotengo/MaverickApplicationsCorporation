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
                "feed" => "tweets"
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
			$page = $_GET['page'];
            $loading = $this->index->searchIndex($page);
			$this->$loading($multparams);
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

        private function authCheck(){
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
        
        private function contPage($params){
			$user = $this->authCheck();
			if($user === true){
                $this->redirect("feed");
            }
			else{
				$this->loadPage($user, "login", array());
			}
		}

        private function signUp(){
            $signup = array(
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname']
            );
            $register = $this->model->registerUser($signup);
            if($register === true){
                $this->redirect("feed");
            }
            else{
                $this->redirect("login");
            }
		}
    
		private function login(){
            $loginInfo = array(
                'username' => $_POST['username'],
                'password' => $_POST['password']
            );
            if(isset($_POST['register'])){
                $this->loadPage($user, 'create', array());
            }
            else if($this->model->attemptLogin($loginInfo) === true){
				$this->redirect("feed");
			}
			else{
				$this->redirect("login");
			}
        }
        
        private function logout(){
			$this->model->logoutUser($_COOKIE['user']);
			$this->redirect("login");
		}
	
		private function submitPost($params){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("login");
			}
			else{
				$postText = $_POST['text'];
				if(strlen($post) > 140){
					$this->redirect("feedpage");
				}
				else{
					$this->model->post($user, $postText);
					$this->redirect("feedpage");
				}
			}
        
		}
	
		private function feed($params){
			$user = $this->authCheck();
			if($user === false){
				$this->redirect("login");
			}
			else{
//          	$postFeed = $this->model->getMainPaigePosts($user->getID());           
				$this->loadPage($user, "feedpage", array('User' => $user, "messages" => $postFeed));
			}
		}	