<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../../db.php');
$story_name = $_POST['story_name'];
$story_topic = $_POST['story_topic'];
$story_first_page = $_POST['story_first_page'];
$story_summary = $_POST['story_summary'];
$story_privacy = $_POST['privacy'];

$query_update = "Update Stories Set
story_name = '$story_name',
story_topic = '$story_topic',
story_first_page = '$story_first_page',
story_summary = '$story_summary',
story_privacy = '$story_privacy'
Where story_id='$story'"; //mysql query variable
$list_update = mysql_query($query_update) or die(mysql_error()); //execute query




echo $story_name." updated.<br />";

?>