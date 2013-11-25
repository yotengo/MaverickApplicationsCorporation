<?php
require ("../Controller.php");
require ("../View.php");
unset($_POST);
$control=new Controller();

function userCreate(){	
		$control = new Controller();
		$view 	= new View();
		$model = new Model();
/*		if(isset($_POST['password'])&&isset($_POST['password2'])){
			if(strcmp($_POST['password'],$_POST['password2'])===0){
				//continue
			}else{
			// echo "<script>alert(\"passwords don't match\")</script>";
			}
		}
	*/	if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])
		&&isset($_POST['firstname'])&&isset($_POST['lastname'])&&isset($_POST['password2'])){
			$control -> signUp();
//			$view -> displayHeader("views/home.php");
		}else{
			//return true;
			// echo "<p> test message </p>";
			$view->displayLogin();
		}
}

echo "<html>".PHP_EOL;
// echo "			<div class=\"panel right\">".PHP_EOL;
echo "<body>".PHP_EOL;
echo "				<h1>New to HALlo?</h1>".PHP_EOL;
// echo "				<p>".PHP_EOL;
echo "		<form action=\"\" method=\"post\">".PHP_EOL;
echo "			<input name=\"email\" type=\"text\" placeholder=\"Email\">".PHP_EOL;
echo "		    <input name=\"username\" type=\"text\" placeholder=\"Username\">".PHP_EOL;
echo "			<input name=\"firstname\" type=\"text\" placeholder=\"First Name\">".PHP_EOL;
echo "			<input name=\"lastname\" type=\"text\" placeholder=\"Last Name\">".PHP_EOL;
echo "		    <input name=\"password\" type=\"password\" placeholder=\"Password\">".PHP_EOL;
echo "		    <input name=\"password2\" type=\"password\" placeholder=\"Confirm Password\">".PHP_EOL;
echo "		   	<button type=\"submit\" name=\"create\" value=\"Submit Form\" onclick=\"userCreate()\">".PHP_EOL;
echo "Create Account";
echo "</button>";
echo "					</form>".PHP_EOL;
// echo "			</p>".PHP_EOL;
// echo "		</div>".PHP_EOL;
			
echo "Back to <a href=login.php>login</a>".PHP_EOL;		
echo "</body>".PHP_EOL;	
			
echo "</html>".PHP_EOL;			
			
?>