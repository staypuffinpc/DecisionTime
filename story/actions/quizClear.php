<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$s = $_SESSION['story'];
$u = $_SESSION['user_id'];
$query = "DELETE from User_Quiz where story='$s' and user_id='$u'"; //mysql query variable
$run = mysql_query($query) or die(mysql_error());

$query = "DELETE from User_Scores where story_id='$s' and user_id='$u'"; //mysql query variable
$run = mysql_query($query) or die(mysql_error());

echo "quiz cleared.<br />"
?>