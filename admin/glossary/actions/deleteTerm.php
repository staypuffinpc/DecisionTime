<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$term_id = $_POST['term_id'];

$query = "Delete from Terms where term_id='$term_id'";
$run = mysql_query($query) or die(mysql_error());


?>