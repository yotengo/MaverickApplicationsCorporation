<?php

	echo "<head>";
		echo "<title>";
		echo "Search";
		echo "</title>";
	echo "</head>";
	echo "<body>";

	echo "<p>";
				echo "	<form action=\"/search\" method=\"post\">";
				echo "	<input name=\"email\" type=\"text\">";
				echo "  <select name=\"option\">";
				echo "		<option value=\"fname\">First Name</option>";
				echo "		<option value=\"lname\">Last Name</option>";
				echo "		<option value=\"uname\">Username</option>";
				echo "		<option value=\"htag\">Hashtag</option>";
				echo "	</select>";
				echo "	<button type=\"submit\" onclick=\"formSubmit()\" value=\"Submit form\">";
				echo "Search";
				echo "	</button>";
				echo "	</form>";
				echo "</p>";
		
	echo "</body>";
echo "</html>";
?>