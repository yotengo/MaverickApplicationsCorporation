<?php
require ("../Controller.php");
require ("../View.php");
$control=new Controller();

if(!isset($_COOKIE['changeattempts'])){
		setcookie('changeattempts',0);
}

echo "<html>".PHP_EOL;
// echo "			<div class=\"panel right\">".PHP_EOL;
echo "<body>".PHP_EOL;
echo "				<h1>Change your password.</h1>".PHP_EOL;
// echo "				<p>".PHP_EOL;
echo "		<form action=\"temp.php\" method=\"post\">".PHP_EOL;
echo "			<input name=\"Password\" type=\"password\" placeholder=\"Password\">".PHP_EOL;
echo "			<p></p>".PHP_EOL;
echo "		    <input name=\"NewPass\" id=\"password\" type=\"password\" placeholder=\"New Password\">".PHP_EOL;
echo "			<p> Password Strength: <span id=\"password_complexity\"></span></p>	".PHP_EOL;
echo "			<input name=\"NewPass2\" type=\"password\" placeholder=\"Confirm New Password\">".PHP_EOL;
echo "			<p></p>".PHP_EOL;
echo "		<button type=\"submit\" name=\"changepass\" onclick=\"";
echo "\" value=".$_COOKIE['changeattempts'].">".PHP_EOL;
echo "Change Password";
echo "</button>";
echo "					</form>".PHP_EOL;
// echo "			</p>".PHP_EOL;
// echo "		</div>".PHP_EOL;
echo "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js\"></script>".PHP_EOL;
echo "<script src=\"jquery.YAPSM.js\"></script>".PHP_EOL;
echo "<script>".PHP_EOL;
echo "	$(\"#password\").yapsm({".PHP_EOL;
echo "   dictionary: function() {".PHP_EOL;
echo "    return [\"admin\", \"test\"];".PHP_EOL;
echo "                }".PHP_EOL;
echo "            })".PHP_EOL;
echo "            .keyup(function() {".PHP_EOL;
echo "                $(\"#password_complexity\").html(this.complexity);".PHP_EOL;
echo "            });".PHP_EOL;
echo "        </script>".PHP_EOL;				
echo "</body>".PHP_EOL;	
			
echo "</html>".PHP_EOL;			
			
?>