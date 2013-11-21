<?php
require("../Controller.php");
//require("../Model.php");

echo "<html>";

echo "<body bgcolor=\"aqua\">";
//<!--the above aqua color is a place holder and will (most likely) change when we nail down what to call the site-->

//<!--The style="float: right;" part is used to keep the logout on the right side of the header (since it looks nicer)-->

echo "<button type=\"submit\" onclick=\"logoutUser()\" value=\"Logout\" style=\"float: right;\">";
echo "Logout";
echo "</button>";
echo "</body>";
echo "</html>";
?>