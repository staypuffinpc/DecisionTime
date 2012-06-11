<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$item_id = $_POST['item_id'];
$value = $_POST['value'];

$query = "Update Quiz_Items set item_answer='$value', modified_by='$user_id', modified_on=NOW() where item_id='$item_id'";
$run = mysql_query($query) or die(mysql_error());

echo "Answer Updated!";


?>