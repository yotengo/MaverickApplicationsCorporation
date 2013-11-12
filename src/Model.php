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
		// Create connection
		$con=mysqli_connect("cse.unl.edu","rcarlso","a@9VUi","rcarlso");

		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else
		{
			$userName = $user->getUserName();
			$password = $user->getPassword();
			$email = $user->getEmail();
			$firstName = $user->getFirstName();
			$lastName = $user->getLastName();
			
			$query = mysqli_prepare($con,"INSERT INTO User(Username,Password,Email,FirstName,LastName) VALUES (?,?,?,?,?)");
			
			//the string "sssss" indicates 5 strings for the database, since their type in php is not explicit.
			$query->bind_param("sssss",$userName,$password,$email,$firstName,$lastName);
			
			$query->execute();
				
		}
			
		//close connection
		mysqli_close($con);
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
	function postHashtag($post,$hashtag)
	{

	}

	/**
	 *
	 * @param takes in two User IDs and deletes the entry associating them from
	 * the databse.
	 * @return nothing to return
	 */
	function unFollowUser($userA,$userB)
	{

	}

	/**
	 * This implementation of likePost assumes user's can only see the like count of the post
	 * There is no association between the user and the posts they've liked. This follows what
	 * I believe is written in the requirements document.
	 *
	 * @param Takes in the ID of the post and updates the likeCount.
	 * @return nothing to return
	 */
	function likePost($post)
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
	private $userID;
	private $post;
	private $timePosted;
	private $numOfLikes;

	public function Post($userID,$post,$timePosted,$numOfLikes)
	{
		$this->userID = $userID;
		$this->post = $post;
		$this->timePosted = $timePosted;
		$this->numOfLikes = $numOfLikes;
	}
	
	function printTimePosted()
	{
		echo $this->timePosted;
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
$hashtag = new Hashtag("Waffles");
$model->createHashtag($hashtag);

?>