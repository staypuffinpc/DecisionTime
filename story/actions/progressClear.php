<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$s = $_SESSION['story'];
$u = $_SESSION['user_id'];
$query_progressClear = "DELETE from User_Progress where progress_story='$s' and progress_user='$u'"; //mysql query variable
$list_progressClear = mysql_query($query_progressClear) or die(mysql_error()); //execute query

echo "progress cleared.<br />"
?>