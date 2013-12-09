<?php
/**
 * Kevin Rock
 * View.php
 */
 

 Class View{
		
		
		
		// /*
		// * This function will display the title bar at the top of each page.
		// * Note: The 50 pixels for the header is pretty arbitrary right now and
		// * can be sorted out later.
		// */
		// function displayHeader($page){
			// echo PHP_EOL."<html>".PHP_EOL;
			// echo PHP_EOL."<frameset rows=\"50,100%\">".PHP_EOL;
			// echo "<frame src=\"header.php\">".PHP_EOL;
			// echo "<frame src=\"".$page."\">".PHP_EOL;
			// echo "</frameset>".PHP_EOL;
			// echo "</html>".PHP_EOL;	
		// }
		
		
		function displayLogin(){
			echo PHP_EOL."<html>".PHP_EOL;
			echo PHP_EOL."<frameset rows=\"100\">".PHP_EOL;
			//echo "<frame src=\"Views/header.php\">".PHP_EOL;
			echo "<frame src=\"Views/login.php\">".PHP_EOL;
			echo "</frameset>".PHP_EOL;
			echo "</html>".PHP_EOL;	
			
		}
		
		function displayLoginSub(){
			echo PHP_EOL."<html>".PHP_EOL;
			echo PHP_EOL."<frameset rows=\"100\">".PHP_EOL;
			//echo "<frame src=\"Views/header.php\">".PHP_EOL;
			echo "<frame src=\"login.php\">".PHP_EOL;
			echo "</frameset>".PHP_EOL;
			echo "</html>".PHP_EOL;	
			
		}
		
			function displayPageSub($page){
				echo PHP_EOL."<html>".PHP_EOL;
				echo PHP_EOL."<frameset rows=\"100\">".PHP_EOL;
				//echo "<frame src=\"Views/header.php\">".PHP_EOL;
				echo "<frame src=\"".$page."\">".PHP_EOL;
				echo "</frameset>".PHP_EOL;
				echo "</html>".PHP_EOL;	
			}
		
		
}
		
		//$view = new View();
		
		$dispage="search.php";
		//$dispage="login.php";
		
		//displayHeader($dispage);
		
		//displayLogin();
		
		//echo "This works.";
		
		//echo "<b> as does this </b>";
		
		
//		testFunc();
		
?>