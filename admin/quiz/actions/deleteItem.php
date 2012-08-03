<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$item_id = $_POST['item_id'];
$story = $_SESSION['story'];

$query = "Delete from Quiz_Items where item_id = '$item_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Delete from Quiz_Responses where item_id='$item_id'";
$run = mysql_query($query) or die(mysql_error());

echo "Item Deleted!";


?>