<?php
/**
 * Ryan Carlson
 * Model.php
 * 11/7/13
 */

/**
 * This Model file takes the objects needed and insert, updates, or selects values from the
 * database.
 *
 * As far as parameters, this class will take in objects of the associated type in order to add them
 * to the database. If the objects already exists in the database, only the associated ID of the object
 * is needed.
 * 
 * This file contains classes used to test the way model works.
 *
 *
 */
Class Model{
	
	function __construct(){
//      $this->db = new mysqli('cse.unl.edu', 'rcarlso', 'a@9VUi', 'rcarlso');
		$this->db = new mysqli('localhost', 'root', 'stephen', 'twatter');
		//Checks that connection was successful
		if (mysqli_connect_errno($this->db))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
    }
	function test()
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			$result = mysqli_query($con,"SELECT * FROM Bands");

			while($row = mysqli_fetch_array($result))
			{
				echo '-----------' . PHP_EOL;
				echo $row['BandID'] . PHP_EOL;
				echo $row['BandName'] . PHP_EOL;
				echo '-----------' . PHP_EOL;

			}
		}
			
		//close connection
		mysqli_close($con);

	}

	/**
	 * This function registers a new user in the database
	 *
	 * @param takes in a user object and creates a new entry in the user table.
	 * @return nothing to return
	 */
	//TESTED
	function registerUser($user)
	{
			$userName = $user['username'];
			$password = $user['password'];
			$email = $user['email'];
			$firstName = $user['firstname'];
			$lastName = $user['lastname'];			
			$query = $this->db->prepare("INSERT INTO User(Username,Password,Email,FirstName,LastName) VALUES (?,?,?,?,?)");			
			//the string "sssss" indicates 5 strings for the database, since their type in php is not explicit.
			$query->bind_param("sssss",$userName,$password,$email,$firstName,$lastName);			
			$query->execute();
			return true;	
	}
	public function cookieCheck($username){
        $query = $this->db->prepare("SELECT Users.* FROM Users WHERE Users.username = ?");
        $query->bind_param("s", $username);
		$query->execute();
		$check = $this->db->query($query);
        if($check->num_rows > 0){
            return $check->fetch_object();
        }
        else{
            return false;
        }
    }
	
    public function attemptLogin($loginInfo){
		$userName = $loginInfo['username'];
		$passwordAttempt = $loginInfo['password'];
		$query = $this->db->prepare("SELECT Username, Password FROM User WHERE Username = ?");
		$query->bind_param("s", $userName);
		$query->execute();
		$query->bind_result($username,$password);
		$query->fetch();
		if($passwordAttempt === $password){
			setcookie("user",$username);
			return true;
		}
		else{
			return false;
		}
    }
    
    public function logoutUser($username){
        $this->delete("user", $username);
    }

	/**
	 * This function creates a join table in the database for a user to follow another user.
	 * 
	 * @param this functions takes the user ids of the users to follow the other. In this case, userA is to follow userB.
	 * @return nothing to return
	 */
	
	//TESTED
	function followUser($userIDA,$userIDB)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"INSERT INTO UserFollowing(UserID,FollowingUserID) VALUES (?,?)");
			
			$query->bind_param("dd",$userIDA,$userIDB);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}

	/**
	 * This method creates an entry in the hashtag following table to allow
	 * the user to follow the indicated hashtag
	 * 
	 * @param takes a userID and hashtagID
	 */
	//NEEDS TESTING
	function followHashtag($userID,$hashtagID)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"INSERT INTO HashtagFollowing(UserID,HashtagID) VALUES (?,?)");
			
			$query->bind_param("dd",$userID,$hashtagID);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}

	/**
	 * This function will create an entry in the post table.
	 * 
	 * @param takes a post object.
	 */
	//TESTED
	function post($post)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			$userID = $post->getUserID();
			$thePost = $post->getPost();
			$timePosted = $post->getTimePosted();
			$numOfLikes = $post->getNumOfLikes();
			
			$query = mysqli_prepare($con,"INSERT INTO Post(UserID,Post,TimePosted,NumOfLikes) VALUES (?,?,?,?)");
			
			$query->bind_param("dssd",$userID,$thePost,$timePosted,$numOfLikes);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}

	/**
	 * This function creates an entry in the hashtag table. This should be called only
	 * if the hashtag is not already in the system.
	 *
	 * @param takes in a hashtag object in the database
	 * @return nothing to return
	 */
	
	//TESTED
	function createHashtag($hashtag)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			$theHashtag = $hashtag->getHashtag();
			
			$query = mysqli_prepare($con,"INSERT INTO Hashtag(Hashtag) VALUES (?)");
			
			$query->bind_param("s",$theHashtag);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}

	/**
	 * This function associates the post with the hashtag.
	 *
	 * @param takes in post's and hashtag's IDs
	 * @return nothing to return
	 */
	//NEEDS TESTING
	function postHashtag($postID,$hashtagID)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"INSERT INTO PostHashtags(UserID,PostID) VALUES (?,?)");
			
			$query->bind_param("dd",$postID,$hashtagID);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}

	/**
	 *
	 * @param takes in two User IDs and deletes the entry associating them from
	 * the databse.
	 * @return nothing to return
	 */
	//TESTED
	function unFollowUser($userIDA,$userIDB)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"DELETE FROM UserFollowing WHERE UserID = ? AND FollowingUserID = ?");
			
			$query->bind_param("dd",$userIDA,$userIDB);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}

	/**
	 * This implementation of likePost assumes user's can only see the like count of the post
	 * There is no association between the user and the posts they've liked. This follows what
	 * I believe is written in the requirements document.
	 *
	 * @param Takes in the ID of the post and updates the likeCount.
	 * @return nothing to return
	 */
	//NEEDS TESTING
	function likePost($postID)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"UPDATE Post SET NumOfLikes = NumOfLikes + 1 WHERE PostID = ?");
			
			$query->bind_param("d",$postID);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}
	
	/**
	 * This function takes in the userID and returns a list of all the posts that should show
	 * up on their main page. This will be posts they posted, posts by users they follow, and hashtags they follow.
	 * The default sorting is by time.
	 * 
	 * @param takes in the userID of the current user.
	 * @return returns a list of posts ordered by time.
	 */
	//NOT FINISHED
	//FINISH THE THREE HELPER METHODS FIRST
	function getMainPagePosts($userID)
	{
		
	}
	
	/**
	 * This function returns the posts by the indicated user
	 * 
	 * @param $userID
	 * @return returns a list of posts by the given user
	 */
	//NOT FINISHED
	function getUserPosts($userID)
	{
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT * FROM Post WHERE UserID = ?");
			
			$query->bind_param("d",$userID);
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				
				$post = new Post($row['PostID'],$row['UserID'],$row['Post'],$row['TimePosted'],$row['NumOfLikes']);
				
				//testing
				$post->printPost();
				
				//NOW WE NEED A LIST FOR OUR NEW POST OBJECTS, THEN RETURN IT.
				
				

			}
		}
			
		//close connection
		mysqli_close($con);
	}
	
	/**
	 * This function returns the posts by the users that the given user is following
	 * 
	 * @param $userID
	 * @return returns a list of posts
	 */
	//NOT FINISHED
	function getFollowedUserPosts($userID)
	{
		
	}
	/**
	 * This function returns a list of posts that have hashtags that the given user is following.
	 * 
	 * @param $userID
	 * @return returns a list of posts
	 */
	//NOT FINISHED
	function getFollowedHashtagPosts($userID)
	{
		
	}



}

/**
 * Test stub for hashtag
 * 
 * @author Ryan
 *
 */
class Hashtag
{
	private $hashtag;
	
	public function Hashtag($hashtag)
	{
		$this->hashtag = $hashtag;
	}
	
	function getHashtag()
	{
		return $this->hashtag;
	}
}

/**
 * This is a stub for the post class
 * @author Ryan
 *
 */
class Post
{
	private $postID;
	private $userID;
	private $post;
	private $timePosted;
	private $numOfLikes;

	//this constructor doesn't give postID.
//	public function Post($userID,$post,$timePosted,$numOfLikes)
//	{
//		$this->userID = $userID;
//		$this->post = $post;
//		$this->timePosted = $timePosted;
//		$this->numOfLikes = $numOfLikes;
//	}
	
	//this constructor gives postID
	//can't overload constructors in php... so the postID has to be given
	//it just won't be used when not needed(null).
	public function Post($postID,$userID,$post,$timePosted,$numOfLikes)// use the date function for current date/time and to make it formatted nicely
	//reference: http://php.net/manual/en/function.date.php
	{
		$this->postID = $postID;
		$this->userID = $userID;
		$this->post = $post;
		$this->timePosted = $timePosted;
		$this->numOfLikes = $numOfLikes;
	}
	
	function printPost()
	{
		echo '-------------' . PHP_EOL;
		echo $this->postID . PHP_EOL;
		echo $this->userID . PHP_EOL;
		echo $this->post . PHP_EOL;
		echo $this->timePosted . PHP_EOL;
		echo $this->numOfLikes . PHP_EOL;
		echo '-------------' . PHP_EOL;
	}
	
	function getUserID()
	{
		return $this->userID;
	}

	function getPost()
	{
		return $this->post;
	}

	function getTimePosted()
	{
		return $this->timePosted;
	}

	function getNumOfLikes()
	{
		return $this->numOfLikes;
	}

}

/**
 * This is a stub for the user class
 * 
 * @author Ryan
 *
 */
class User
{
	private $userID;
	private $userName;
	private $password;
	private $email;
	private $firstName;
	private $lastName;

	public function User($userName,$password,$email,$firstName,$lastName)
	{
		$this->userName = $userName;
		$this->password = $password;
		$this->email = $email;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
	}

	function printUser()
	{
		echo 'UserName = ' . $this->userName . PHP_EOL;
	}
	
	function getUserName()
	{
		return $this->userName;
	}

	function getPassword()
	{
		return $this->password;
	}

	function getEmail()
	{
		return $this->email;
	}

	function getFirstName()
	{
		return $this->firstName;
	}

	function getLastName()
	{
		return $this->lastName;
	}

}

//<<<<<<< HEAD
//=======


//$model = new Model();

//testing userFollowing
//$model->followUser(1, 5);

//testing user registration
//$user = new User("yotengo","1234","yotengo@gmail.com","Ryan","Carlson");
//$model->registerUser($user);

//testing creating new post
//$post = new Post(1,"I like cheese.","date",0);
//$model->post($post);

//testing creating a hashtag
//$hashtag = new Hashtag("Waffles");
//$model->createHashtag($hashtag);

//testing unfollowing a user
//$model->unFollowUser(2,5);

//testing get getUserPosts
//model->getUserPosts(1);



//>>>>>>> f0001cb24be17d47a42649f8f1976cc5bdfbff26
?>