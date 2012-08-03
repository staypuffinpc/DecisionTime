<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$page = $_POST['page'];
$id = $_POST['id'];

$query = "Update Worksheet set worksheet_page = '$page' where worksheet_id='$id'";
$run = mysql_query($query) or die(mysql_error());
echo "updated";
?>
