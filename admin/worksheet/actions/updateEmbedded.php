<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$id = $_POST['id'];
$embedded = $_POST['embedded'];


$query = "Update Worksheet set embedded='$embedded' where worksheet_id='$id'";
$run = mysql_query($query) or die(mysql_error());
echo "Updated";
?>
