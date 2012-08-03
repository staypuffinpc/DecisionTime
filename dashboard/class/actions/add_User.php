<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$class_id = $_SESSION["class_id"];
$user_id = $_POST["searchForUser-id"];

$query = "Insert into Class_Members (class_id, user_id) values ('$class_id','$user_id')";
$run = mysql_query($query) or die(mysql_error());

echo $_POST['searchForUser']." has been added to the class.";
?>