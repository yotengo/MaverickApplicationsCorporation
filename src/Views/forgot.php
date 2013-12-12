<?php
echo "<!DOCTYPE html>";
	echo "<head>";
	echo "	<title>";
	echo "	Recover Password";
	echo "	</title>";
		/*function validateForm()
			{
				var x=document.forms["email"]["uname"].value;
				if (x==null || x=="")
				{
					alert("Must provide a valid username.");
						return false;
				}
			}*/
	echo "</head>";
	echo "<body>";
	echo "	<form name=\"email\" action=\"temp.php\" method=\"post\">";
	echo "		Email: <input type=\"text\" name=\"email\"><br>";
	echo "		<button type=\"submit\" name=\"forgotpass\" value=\"Submit Form\" onclick=\"return true\">".PHP_EOL;
	echo "		Forgot Password";
	echo "		</button>";
	echo "	</form> ";
		
echo "	</body>";
echo " </html>";
?>
