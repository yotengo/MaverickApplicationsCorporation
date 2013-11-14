
<!--this will be the first page on the site that users will see-->
	<head>
		<title>
		Login
		</title>
	</head>
	<body>
		<form name="login" action="/login" method="post" onsubmit="return validateForm()">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			<button type="submit" onclick="formSubmit()" value="Submit form">
			Login
			</button>
			<button type="s" name="register" value="false" onclick="return true">
			Create an Account
			</button>
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
