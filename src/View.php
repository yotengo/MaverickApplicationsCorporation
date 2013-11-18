<?php
/**
 * Kevin Rock
 * View.php
 */

		/* 
		*	A function that given a list/array of posts, 
		*	will display them chronologically with newest at the top
		*/
		function displayPosts($PostList){
		
		
		}
		
		
		/*
		* This function will display the title bar at the top of each page.
		* Note: The 50 pixels for the header is pretty arbitrary right now and
		* can be sorted out later.
		*/
		function displayHeader($page){
		echo PHP_EOL."<html>".PHP_EOL;
		echo PHP_EOL."<frameset rows=\"50,100%\">".PHP_EOL;
		echo "<frame src=\"header.php\">".PHP_EOL;
		echo "<frame src=\"".$page."\">".PHP_EOL;
		echo "</frameset>".PHP_EOL;
		echo "</html>".PHP_EOL;	
		}
		
		function testFunc(){
		
			echo "<br/>will this work?". "<br/>".PHP_EOL;
			echo "This is test function.".PHP_EOL;
			
		}
		
		
		$dispage="login.php";
		
		displayHeader($dispage);
		
		echo "This works.";
		
		echo "<b> as does this </b>";
		
		
		testFunc();
		
?>