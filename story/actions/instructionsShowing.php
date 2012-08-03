<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$instructionsShowing = $_POST['instructionsShowing'];

$query = "Update Users set instructionsShowing='$instructionsShowing' where user_id='$user_id'";
$run = mysql_query($query) or die(mysql_error());


?>