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
	echo "	<form name=\"email\" action=\"email_pw.php\" method=\"post\" onsubmit=\"return true\">";
	echo "		Username: <input type=\"text\" name=\"uname\"><br>";
	echo "		<button type=\"submit\" onclick=\"formSubmit()\" value=\"Submit form\">";
	echo "		Email";
	echo "		</button>";
	echo "	</form> ";
		
echo "	</body>";
echo " </html>";
?>
