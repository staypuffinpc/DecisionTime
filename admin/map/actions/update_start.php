<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$page_id = $_POST['page_id'];
$story = $_SESSION['story'];

$query = "Update Stories set story_first_page = '$page_id' where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());

echo "Start Page Has been changed.";

?>