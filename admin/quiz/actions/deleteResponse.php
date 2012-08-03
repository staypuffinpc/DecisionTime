<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$id = $_POST['id'];

$query = "Delete from Quiz_Responses where id='$id'";
$run = mysql_query($query) or die(mysql_error());


echo "Repsonse deleted!"

?>