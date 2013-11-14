
<!--this will be the first page on the site that users will see-->
	<head>
		<title>
		Login
		</title>
	</head>
	<body>
		<form name="login" action="/login" method="post" onsubmit="return validateForm()">
			Username: <input type="text" name="uname"><br>
			Password: <input type="password" name="pword"><br>
			<button type="submit" onclick="formSubmit()" value="Submit form">
			Login
			</button>
			<button type="button" name="register" value="Register onclick="location.href='create.php'">
			Create an Account
			<button>
		</form> 
		<p>
		<a href="recover.html">Forgot password?</a>
		</p>
		
		<!--below code doesn't work-->
		<?php
			echo "Php is working.";
		?>
		
	</body>
</html>
