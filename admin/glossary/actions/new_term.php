<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$user_id = $_SESSION['user_id'];

$query = "Insert Into Terms (term, definition, story, term_author, term_created) Values (' New Term', ' No definition provided', '$story', '$user_id', NOW())";
$run = mysql_query($query) or die(mysql_error());
$lastItemID = mysql_insert_id();
echo $lastItemID;

?>	