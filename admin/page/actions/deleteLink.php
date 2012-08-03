<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$page_parent = $_SESSION['current_page'];
$id = $_POST['id'];

$query = "DELETE FROM Page_Relations WHERE page_relation_id = '$id'";
$run = mysql_query($query) or die(mysql_error());

echo $id." is deleted.";
?>