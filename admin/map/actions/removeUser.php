<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$user_id = $_POST['user_id'];

$query = "DELETE FROM author_permissions WHERE user_id = '$user_id' and story_id = '$story'";
$run = mysql_query($query) or die(mysql_error());

echo "User Removed";

?>