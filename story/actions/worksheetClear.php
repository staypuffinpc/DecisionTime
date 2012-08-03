<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$m = $_SESSION['story'];
$u = $_SESSION['user_id'];
$query_progressClear = "DELETE from User_Worksheet where story='$m' and user_id='$u'"; //mysql query variable
$list_progressClear = mysql_query($query_progressClear) or die(mysql_error()); //execute query
echo "worksheet cleared.<br />"
?>