<?php
/**
 * Ryan Carlson
 * Stephen Pandorf
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
	 * @author Ryan, Stephen
	 */
	//NEEDS TESTING
	function registerUser($user)
	{
		$conn = mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		if (mysqli_connect_errno($conn))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
			$userName = $user['username'];
			$password = $user['password'];
			$email = $user['email'];
			$firstName = $user['firstname'];
			$lastName = $user['lastname'];			
			$query = $conn->prepare("INSERT INTO User(Username,Password,Email,FirstName,LastName) VALUES (?,?,?,?,?)");			
			//the string "sssss" indicates 5 strings for the database, since their type in php is not explicit.
			$query->bind_param("sssss",$userName,$password,$email,$firstName,$lastName);			
			$query->execute();
			$query->close();
			$conn->close();
			return true;	
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $username
	 * @author Stephen
	 */
	public function cookieCheck($username){
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		// $con=new mysqli("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
        $query = $con->prepare(/*$con,*/"SELECT User.* FROM User WHERE User.Username = ?");
        // if($query===false){
			// return false;
		// }
		$query->bind_param("s", $username);
		$query->execute();
		$check =  $query->get_result();
		// $con->query($query);//this was how it was
        if($check->num_rows > 0){
			// print_r($check->fetch_object());//debugging
            return $check->fetch_object();
        }else{
            return false;
        }
		$query->close();
		$con->close();
		
		//below portion
		//@author Kevin
		// if(isset($_COOKIE['user'])&&($_COOKIE['user']!="")){
			// if(strcmp($_COOKIE['user'],$username)===0){
				// return true;
			// }	
		// }else{
			// return false;
		// }
    }
	public function changePass($oldpass, $newpass, $userid)
		{
		$oldPass = $oldpass;
		$newPass = $newpass;
		$userID = $userid;
		$conn = mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		if (mysqli_connect_errno($conn))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			$query2 = $conn->prepare("Select Password FROM User WHERE UserID = ?");
			$query2->bind_param("s", $userID);
			$query2->execute();
			$query2->bind_result($oldpassword);
			$query2->fetch();
			$query2->close();
			if($oldpassword === $oldPass){
				$query = $conn->prepare("UPDATE User SET Password=? WHERE UserID = ?");			
				//the string "sssss" indicates 5 strings for the database, since their type in php is not explicit.
				$query->bind_param("ss",$newPass,$userID);			
				$query->execute();
				$query->close();
				$conn->close();
				return true;	
			}
			else{
				$conn->close();
				return false;
			}

		}
	}
	
    /**
     * 
     * Enter description here ...
     * @param $loginInfo
     * @author Stephen
     */
    public function attemptLogin($loginInfo){
		$conn=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		if (mysqli_connect_errno($conn))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$userName = $loginInfo['username'];
		$passwordAttempt = $loginInfo['password'];
		$query = $conn->prepare("SELECT Username, Password FROM User WHERE Username = ?");
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
		$query->close();
		$conn->close();
    }
    
    /**
     * 
     * Enter description here ...
     * @param $username
     * @author Stephen
     */
    public function logoutUser($username){
		setcookie('user', '', time()-60*60*24*365);
    }

	/**
	 * This function creates a join table in the database for a user to follow another user.
	 * 
	 * @param this functions takes the user ids of the users to follow the other. In this case, userA is to follow userB.
	 * @return nothing to return
	 * @author Ryan
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
	 * This function will indicate whether userA is following userB
	 * @param takes in two user ids
	 * @return returns 1 if userA is following userB, 0 otherwise
	 * @author Ryan
	 */
	//TESTED
	function checkIfFollowingUser($userIDA,$userIDB)
	{
		$exists = 0;
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT * FROM UserFollowing");
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				if($userIDA == $row['UserID'] && $userIDB == $row['FollowingUserID'])
				{
					$exists = 1;
				}
			}
		}
		
		
			
		//close connections
		mysqli_close($con);
		return $exists;
	}
	
	/**
	 * This function will indicate whether the user is following a given hashtag
	 * @param takes in a userID and hashtagID
	 * @return returns 1 if user is following hashtag, 0 otherwise
	 * @author Ryan
	 */
	//TESTED
	function checkIfFollowingHashtag($userID,$hashtagID)
	{
		$exists = 0;
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT * FROM HashtagFollowing");
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				if($userID == $row['UserID'] && $hashtagID == $row['HashtagID'])
				{
					$exists = 1;
				}
			}
		}
		
		
			
		//close connections
		mysqli_close($con);
		return $exists;
	}

	/**
	 * This method creates an entry in the hashtag following table to allow
	 * the user to follow the indicated hashtag
	 * 
	 * @param takes a userID and hashtagID
	 * @author Ryan
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
	 * @author Ryan
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
			
			$query->bind_param("dsss",$userID,$thePost,$timePosted->format('Y-m-d H:i:s'),$numOfLikes);
			//above was dssdss
			
			$query->execute();
			
			
			
			//below by Kevin
			// if($query===false){
				// return false;
			// }
			// echo $query;//this can be used to show errors
				
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
	 * @author Ryan
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
	 * @author Ryan
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
			
			$query = mysqli_prepare($con,"INSERT INTO PostHashtags(PostID,HashtagID) VALUES (?,?)");
			
			$query->bind_param("dd",$postID,$hashtagID);
			
			$query->execute();
			
			// echo $query;//debugging
				
		}
			
		//close connection
		mysqli_close($con);
	}

	/**
	 *
	 * @param takes in two User IDs and deletes the entry associating them from
	 * the databse.
	 * @return nothing to return
	 * @author Ryan
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
	 * @author Ryan
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
	 * up on their main page. This will be posts they posted, and posts by users they follow.
	 * The default sorting is by time.
	 * 
	 * @param takes in the userID of the current user.
	 * @return returns a list of posts ordered by time.
	 * @author Ryan
	 */
	//TESTED
	function getMainPagePosts($userID)
	{
		$myPosts = $this->getUserPosts($userID);
		$theirPosts = $this->getFollowedUserPosts($userID);
		$mainPageList = array();
		
		for($i=0;$i<count($myPosts);$i++)
		{
			$mainPageList[$i] = $myPosts[$i];
		}
		for($i=count($myPosts);$i<count($myPosts) + count($theirPosts);$i++)
		{
			$mainPageList[$i] = $theirPosts[$i-count($myPosts)];
		}
		
		// print_r($mainPageList);
		
		return $this->sortPostsByDate($mainPageList);
		
		
	}
	
	/**
	 * This function returns the posts by the indicated user
	 * 
	 * @param $userID
	 * @return returns an array of posts by the given user
	 * @author Ryan
	 */
	//TESTED
	function getUserPosts($userID)
	{
		$i=0;
		$posts = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			// $query = mysqli_prepare($con,"SELECT  p.PostID, p.UserID, p.Post, 
				// p.TimePosted, post.NumOfLikes, u.Username, u.FirstName, u.LastName FROM Post p, User u WHERE u.UserID, p.UserID = ?");
			$query = $con->prepare(/*$con,*/"SELECT  p.PostID, p.UserID, p.Post, 
				p.TimePosted, p.NumOfLikes, u.Username, u.FirstName, u.LastName FROM Post p, User u WHERE p.UserID = ? AND u.UserID = ?");
			// if($query===false){
				// return false;
			// }
			
			
			// if ( false===$query) {//debugging mysqli
				// die('prepare() failed: ' . htmlspecialchars($con->error));
				// return false;
			// }
			
			
			// print_r($query);
 			$query->bind_param("dd",$userID,$userID);
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				$fullname = $row['FirstName'] . ' ' . $row['LastName'];
				$post = new Post($row['PostID'],$row['UserID'],$row['Post'],$row['TimePosted'],$row['NumOfLikes'],$row['Username'],$fullname);
				
				// print_r($post);
				
				$posts[$i] = $post;
				
				
				$i++;
			}
		}
		
			
		//close connections
		mysqli_close($con);
		
		
		// print_r($posts);//debugging
		return $this->sortPostsByDate($posts);
		
	}
	
	/**
	 * This function returns the posts by the users that the given user is following.
	 * Default sorting by date.
	 * 
	 * @param $userID
	 * @return returns a list of posts
	 * @author Ryan
	 */
	//TESTED
	function getFollowedUserPosts($userID)
	{
		$i=0;
		$posts = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT Post.PostID, Post.UserID, Post.Post, 
				Post.TimePosted, Post.NumOfLikes, User.UserName, User.FirstName, User.LastName FROM Post JOIN User AS FollowedUser ON Post.UserID = 
				FollowedUser.UserID JOIN UserFollowing ON FollowedUser.UserID = 
				UserFollowing.FollowingUserID JOIN User ON UserFollowing.UserID = User.UserID WHERE User.UserID = ?");
			
			// if($query===false){
				// return false;
			// }	

			if ( false===$query) {//debugging mysqli
				die('prepare() failed: ' . htmlspecialchars($con->error));
				return false;
			}			
			
			$query->bind_param("d",$userID);
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				$fullname = $row['FirstName'] . ' ' . $row['LastName'];
				$post = new Post($row['PostID'],$row['UserID'],$row['Post'],$row['TimePosted'],$row['NumOfLikes'],""/*$row['Username']*/,$fullname);
				
				// print_r($post);
				
				$posts[$i] = $post;
				
				
				$i++;
			}
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $this->sortPostsByDate($posts);
		
	}
	/**
	 * This function returns a list of posts that have hashtags that the given user is following.
	 * 
	 * @param $userID
	 * @return returns a list of posts
	 */
	//TESTED
	function getFollowedHashtagPosts($userID)
	{
		$i=0;
		$posts = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT Post.PostID, Post.UserID, Post.Post, 
				Post.TimePosted, Post.NumOfLikes, Post.Username, Post.Name, User.UserName, User.FirstName, User.LastName FROM Post JOIN PostHashtags ON Post.PostID = 
				PostHashtags.PostID JOIN Hashtag ON PostHashtags.HashtagID = Hashtag.HashtagID JOIN 
				HashtagFollowing ON Hashtag.HashtagID = HashtagFollowing.HashtagID JOIN User ON 
				HashtagFollowing.UserID = User.UserID WHERE User.UserID = ?");
			
			$query->bind_param("d",$userID);
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				$fullname = $row['FirstName'] . ' ' . $row['LastName'];
				$post = new Post($row['PostID'],$row['UserID'],$row['Post'],$row['TimePosted'],$row['NumOfLikes'],$row['Username'],$fullname);
				
				// print_r($post);//debugging
				$posts[$i] = $post;
				
				
				$i++;
			}
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $this->sortPostsByDate($posts);
	}
	
	/**
	 * This function sorts the posts by date. This is done in the database since it is the default sort. Other
	 * sorting should be done by the controller.
	 * 
	 * @param array $posts
	 * @return returns a sorted array of posts
	 * @author Ryan
	 */
	//TESTED
	private function sortPostsByDate($posts)
	{
		
		usort($posts, array($this, 'cmp'));
		
		return $posts;
	}

	/**
	 * this is a callback function used to sort posts by their timePosted variable.
	 * Basically, it's a comparator for the post class.
	 * 
	 * @param Two post objects
	 * @author Ryan
	 */
	private function cmp($postA,$postB)
	{
		if((!(is_object($postA)))||(!(is_object($postB)))){
			return 0;
		}
		$dateA = date_create_from_format('Y-m-d H:i:s',$postA->getTimePosted(),new DateTimeZone('America/Chicago'));
		$dateB = date_create_from_format('Y-m-d H:i:s',$postB->getTimePosted(),new DateTimeZone('America/Chicago'));
			
			
		
		if($dateA == $dateB)
		{
			return 0;
		}
		else if($dateA < $dateB)
		{
			return 1;
		}
		else if($dateA > $dateB)
		{				
			return -1;
		}
		else
		{
			echo 'Something went wrong with sorting of posts by date!';
		}
			
	}
	
	
	
	/**
	 * This function checks if the given hashtag exists in the database.
	 * 
	 * @param String $hashtag
	 * @return returns 1 if exists, 0 otherwise
	 * @author Ryan
	 */
	//TESTED
	function checkIfHashtagExists($hashtag)
	{
		$exists = 0;
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT * FROM Hashtag");
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				if(strcmp($hashtag,$row['Hashtag']) == 0)
				{
					$exists = 1;
				}
			}
		}
		
		
			
		//close connections
		mysqli_close($con);
		return $exists;
	}
	
	/**
	 * This function returns a list of all the users in the system.
	 * 
	 * @param nothing
	 * @return returns a list of user objects
	 * @author Ryan
	 */
	//TESTED
	function getListOfAllUsers()
	{
		$i=0;
		$users = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT * FROM User");
						
			$query->execute();
			
			$result = $query->get_result();
			
			//debugging
			// echo $result;
							
			while($row = mysqli_fetch_array($result))
			{
			
				// echo $row;
				
				$user = new User($row['UserID'],$row['Username'],$row['Password'],$row['Email'],$row['FirstName'],$row['LastName']);
				
				$users[$i] = $user;
				
				
				$i++;
			}
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $users;
	}
	
	/**
	 * This function returns a list of all the hashtags in the system.
	 * 
	 * @param nothing
	 * @return list of hashtag objects
	 * @author Ryan
	 */
	//TESTED
	function getListOfAllHashtags()
	{
		$i=0;
		$hashtags = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT * FROM Hashtag");
						
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				
				$hashtag = new Hashtag($row['HashtagID'],$row['Hashtag']);
				
				$hashtags[$i] = $hashtag;
				
				
				$i++;
			}
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $hashtags;
	}
	
	/**
	 * This function can be used for searching by username, it returns a list of
	 * posts by the user with the indicated username
	 * 
	 * @param takes in a (String) username
	 * @return returns a list of post objects
	 * @author Ryan
	 */
	//TESTED
	function getPostsByUsername($username)
	{
		$i=0;
		$posts = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT Post.PostID, Post.UserID, Post.Post, 
				Post.TimePosted, Post.NumOfLikes, Post.Username, Post.Name, User.UserName, User.FirstName, User.LastName FROM Post JOIN User ON Post.UserID = 
				User.UserID WHERE User.UserName = ?");
			
			$query->bind_param("s",$username);
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				$fullname = $row['FirstName'] . ' ' . $row['LastName'];
				$post = new Post($row['PostID'],$row['UserID'],$row['Post'],$row['TimePosted'],$row['NumOfLikes'],$row['Username'],$fullname);
				
				$posts[$i] = $post;
				
				
				$i++;
			}
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $this->sortPostsByDate($posts);
	}
	
	/**
	 * This function can be used for searching by hashtag and generally 
	 * displaying all posts that have a certain hashtag, it returns a list of
	 * posts that have the indicated hashtag
	 * 
	 * @param takes in a (String) hashtag
	 * @return returns a list of post objects
	 * @author Ryan
	 */
	//TESTED
	function getPostsByHashtag($hashtag)
	{
		$i=0;
		$posts = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			$query = mysqli_prepare($con,"SELECT Post.PostID, Post.UserID, Post.Post, Post.TimePosted, 
				Post.NumOfLikes, User.UserName, User.LastName, User.FirstName FROM User JOIN Post ON User.UserID = Post.UserID 
				JOIN PostHashtags ON Post.PostID = PostHashtags.PostID JOIN Hashtag ON PostHashtags.HashtagID = Hashtag.HashtagID 
				WHERE Hashtag.Hashtag = ?");
				
				
			// if ( false===$query) {//debugging mysqli
				// die('prepare() failed: ' . htmlspecialchars($con->error));
				// return false;
			// }
				
			
			$query->bind_param("s",$hashtag);
			
			$query->execute();
			
			$result = $query->get_result();
							
			while($row = mysqli_fetch_array($result))
			{
				$fullname = $row['FirstName'] . ' ' . $row['LastName'];
				$post = new Post($row['PostID'],$row['UserID'],$row['Post'],$row['TimePosted'],$row['NumOfLikes']);
				
				$posts[$i] = $post;
				
				
				$i++;
			}
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $this->sortPostsByDate($posts);
	}
	
	/**
	 * This function updates the entry in User with the new password.
	 * 
	 * @param takes in userID and (String) newPassword
	 * @return nothing to return
	 * @author Ryan
	 */
	//TESTED
	function changePassword($userID,$newPassword)
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
			$query = mysqli_prepare($con,"UPDATE User SET Password = ? WHERE UserID = ?");
			
			$query->bind_param("sd",$newPassword,$userID);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
	}
	
	/**
	 * This function returns a list of users that match $username on either
	 * their username or first or last name.
	 * 
	 * FOR DEBUGGING: make sure any leading or trailing spaces are trimmed from 
	 * the string before passing it into this method!
	 * 
	 * @param takes in a (String) representing either the username or first last name of the user
	 * @return returns a list of user objects that match the search criteria
	 * @author Ryan
	 */
	function searchForUser($username)
	{
		$i=0;
		$users = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			//if searching with two words (by full name)
			if (preg_match ('/[ ]/', $username)) {
			
				$name = explode(" ",$username);
				$firstName = $name[0];
				$lastName = $name[1];
				
				$firstName = '%' . $firstName . '%';
				$lastName = '%' . $lastName . '%';
				
			
			
			
				$query = mysqli_prepare($con,"SELECT * FROM User WHERE FirstName LIKE ? AND LastName LIKE ?");
			
				$query->bind_param("ss",$firstName,$lastName);
			
				$query->execute();
			
				$result = $query->get_result();
							
				while($row = mysqli_fetch_array($result))
				{
				
					$user = new User($row['UserID'],$row['Username'],$row['Password'],$row['Email'],$row['FirstName'],$row['LastName']);
				
					$users[$i] = $user;
				
				
					$i++;
				}
			
			
			}
			//if searching with one word (by username, firstname, or lastname)
			else
			{
				//changing the string like this will allow it to match on partial entry
				$username = '%' . $username . '%';
				$query = mysqli_prepare($con,"SELECT * FROM User WHERE FirstName LIKE ? 
					OR LastName LIKE ? OR Username LIKE ?");
			
				$query->bind_param("sss",$username,$username,$username);
			
				$query->execute();
			
				$result = $query->get_result();
							
				while($row = mysqli_fetch_array($result))
				{
				
					$user = new User($row['UserID'],$row['Username'],$row['Password'],$row['Email'],$row['FirstName'],$row['LastName']);
					
					$users[$i] = $user;
				
				
					$i++;
				}
			}
		
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $users;
		
	}
	
	
	/**
* This function returns a user id given a username
* @author Kevin
* return UserId
*/
	function getUserIdbyUsername($userName){
		$conn=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		if (mysqli_connect_errno($conn)){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$query = $conn->prepare("SELECT UserID FROM User WHERE Username = ?");
		$query->bind_param("s", $userName);
		$query->execute();
		$query->bind_result($userId);
		$query->fetch();
	
		$query->close();
		$conn->close();
		return $userId;
	}
	
	
/**
* This function returns a post id given the content of the post
* (Since two posts could have the same content, this will just return the most recent one, 
* since this function is primary to associate hashtags and posts)
* @author Kevin
* return PostId
*/
	function getPostIdbyContent($post){
		$conn=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		if (mysqli_connect_errno($conn)){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$query = $conn->prepare("SELECT PostID FROM Post WHERE Post = ?");
		$query->bind_param("s", $post);
		$query->execute();
		$query->bind_result($postId);
		$query->fetch();
	
		$query->close();
		$conn->close();
		return $postId;
	}
	
	
	/**
* This function returns a hashtag id given the hashtag
* @author Kevin
* return HashtagId
*/
	function getHashtagIdbyHashtag($hashtag){
		$conn=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");
		if (mysqli_connect_errno($conn)){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$query = $conn->prepare("SELECT HashtagID FROM Hashtag WHERE Hashtag = ?");
		$query->bind_param("s", $hashtag);
		$query->execute();
		$query->bind_result($hashtagId);
		$query->fetch();
	
		$query->close();
		$conn->close();
		return $hashtagId;
	}
	

	/**
	 * This function returns a list of hashtags that match $hashtag.
	 * 
	 * FOR DEBUGGING: make sure any leading or trailing spaces are trimmed from 
	 * the string before passing it into this method!
	 * 
	 * @param takes in a (String) representing the hashtag
	 * @return returns a list of hastag objects that match the search criteria
	 * @author Kevin (copied from searchForUser)
	 */
	function searchForHashtag($hashtag)
	{
		$i=0;
		$hashtags = array();
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			
			//if searching with one word (by hashtag)
			
				//changing the string like this will allow it to match on partial entry
				$hashtag = '%' . $hashtag . '%';
				$query = mysqli_prepare($con,"SELECT * FROM Hashtag WHERE Hashtag LIKE ?");
			
				$query->bind_param("s",$hashtag);
			
				$query->execute();
			
				$result = $query->get_result();
							
				while($row = mysqli_fetch_array($result))
				{
				// public function Hashtag($hashtagID,$hashtag)
					$hashtag1 = new Hashtag($row['HashtagID'],$row['Hashtag']);
					
					$hashtags[$i] = $hashtag1;
				
				
					$i++;
				}
			
		
		}
		
			
		//close connections
		mysqli_close($con);
		
		return $hashtags;
		
	}
	
	
function makeHashtag(){
	// $control = new Controller();
	// $view 	= new View();
	// $model = new Model();
	
	$j=0;
	$hashtagids=array();
	$postText = $_POST['textarea'];
	// $postText = $_COOKIE['textarea'];
	$hashTagtext="";
	$make=false;
	for($i=0;$i<strlen($postText);$i++){
		if($postText[$i]==='#'){
			$make=true;
			// $hashTagtext=$hashTagtext.postText.charAt(i);
		}else if(($postText[$i]===' ')||($postText[$i]==='.')||($postText[$i]==='?')||($postText[$i]===',')){
		//the above assumes hashtags can't have whitespace or punctuation marks
			if($make===true){
				$hashTag = new Hashtag(0,$hashTagtext);
				if($this->checkifHashtagExists($hashTagtext)===0){//if the 'new' hashtag doesn't already exist,
					$this->createHashtag($hashTag);
				}
				$hashtagids[$j]=$this->getHashtagIdbyHashtag($hashTagtext);
				$j++;
				$make=false;
				$hashTagtext="";
			}
		}else if($make===true){
			$hashTagtext.=$postText[$i];
		}
	}
	
	if($make===true){
		$hashTag = new Hashtag(0,$hashTagtext);
		if($this->checkifHashtagExists($hashTagtext)===0){//if the 'new' hashtag doesn't already exist,
			$this->createHashtag($hashTag);
		}
		$hashtagids[$j]=$this->getHashtagIdbyHashtag($hashTagtext);
		$j++;
		$make=false;
	}
	
	if(!empty($hashtagids)){//if there are hashtags, associate them with the post 
		// echo "associate is executing";
		$this->associateHashtags($hashtagids);
	}
}

function associateHashtags($hashtagids){//only the last one is associated for some reason
	// $control = new Controller();
	// $view 	= new View();
	// $model = new Model();
	
	echo "<br/> Hashtagids: ";
	print_r($hashtagids);
	echo "<br/>";
	// $postid=$this->getPostIdbyContent($_COOKIE['textarea']);
	$postid=$this->getPostIdbyContent($_POST['textarea']);
	// for($i=0;$i<count($hashtagids);$i++){
		// $model->postHashtag($postid,$hashtagids[$i]);
	// }
	foreach($hashtagids as $key=> $value){
		$this->postHashtag($postid,$value);
	}
	
}
	
	
}//end of Model class


	








/**
 * Test stub for hashtag
 * 
 * @author Ryan
 *
 */
class Hashtag
{
	private $hashtagID;
	private $hashtag;
	
	public function Hashtag($hashtagID,$hashtag)
	{
		$this->hashtagID = $hashtagID;
		$this->hashtag = $hashtag;
	}
	
	function getHashtag()
	{
		return $this->hashtag;
	}
	
	function getHashtagID()
	{
		return $this->hashtagID;
	}
	
	
}

/**
 * This is a stub for the post class. Notice we don't need to provide the date, it will be
 * constructed with a dateTime object representing the current time and date in this timezone.
 * @author Ryan
 *
 */
class Post
{
	private $postID;
	private $userID;
	private $post;
	private $timePosted;	//dateTime
	private $numOfLikes;
	private $userName;
	private $name;

	
	//can't overload constructors in php... so the postID has to be given
	//it just won't be used when not needed(null).
	public function Post($postID,$userID,$post,$timePosted,$numOfLikes)// use the date function for current date/time and to make it formatted nicely
	{
		$this->postID = $postID;
		$this->userID = $userID;
		$this->post = $post;
		$this->timePosted = $timePosted;
		$this->numOfLikes = $numOfLikes;
		// $this->userName = $userName;
		// $this->name = $name;
	}
	
	function printPost()
	{
		echo '-------------' . PHP_EOL;
		echo $this->postID . PHP_EOL;
		echo $this->userID . PHP_EOL;
		echo $this->post . PHP_EOL;
		if(is_object($this->timePosted)){
			echo $this->timePosted->format('Y-m-d H:i:s') . PHP_EOL;
		}else{
			echo $this->timePosted .PHP_EOL;//since the date is stored in the database as a string, it won't be an object
		}
		// echo "Time Posted: ".PHP_EOL;
		echo $this->numOfLikes . PHP_EOL;
		echo '-------------' . PHP_EOL;
	}
	
	function getPostID()
	{
		return $this->postID;
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
	
		function getUserName()
	{
		return $this->userName;
	}

		function getName()
	{
		return $this->name;
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

	public function User($userID,$userName,$password,$email,$firstName,$lastName)
	{
		$this->userID = $userID;
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
	
	function getUserID()
	{
		return $this->userID;
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


$model = new Model();

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
//print_r($model->getUserPosts(1));

//testing getFollowedUserPosts
//print_r($model->getFollowedUserPosts(2));

//testing use of DateTime to create a post
//$time = new DateTime('NOW',new DateTimeZone('America/Chicago'));
//$post = new Post(99,1,"I am still user 1",$time,0);
//
//$model->post($post);

//printing the date as a string
//echo $time->format('Y-m-d H:i:s');

//testing sort postsByDate
//echo 'Before sort' . PHP_EOL;
//print_r($model->getUserPosts(1));
//
//
//$posts = $model->getUserPosts(1);
//
//echo 'After sort' . PHP_EOL;
////the sorted version of the array is the one
////returned from the method
//print_r($model->sortPostsByDate($posts));

//testing getMainPagePosts()
//print_r($model->getMainPagePosts(2));

//testing checkIfHashtagExists
//echo $model->checkIfHashtagExists('waffles');

//testing getListOfAllUsers
//print_r($model->getListOfAllUsers());

//testing getListOfAllHashtags
//print_r($model->getListOfAllHashtags());

//testing getFollowedHashtagPosts
//print_r($model->getFollowedHashtagPosts(1));

//testing checkIfFollowingUser
//echo $model->checkIfFollowingUser(2,5);

//testing checkIfFollowingHashtag
//echo $model->checkIfFollowingHashtag(1,1);

//testing getPostsByUsername
//print_r($model->getPostsByUsername("newUser"));

//testing getPostsByHashtag
//print_r($model->getPostsByHashtag("freebird"));

//testing searchForUser
//print_r($model->searchForUser('bo'));










//>>>>>>> f0001cb24be17d47a42649f8f1976cc5bdfbff26
?>