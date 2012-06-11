
<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$id=$_POST['page'];
/*
$top = $_POST['top'];
$left = $_POST['left'];

$update = "UPDATE Pages SET 
page_left = '".$left."', 
page_top = '".$top."'
WHERE id=".$id;
$result = mysql_query($update) or die(mysql_error());
*/


$query_update_line = "Select * from Page_Relations where page_parent=".$id; //mysql query variable
$list_update_line = mysql_query($query_update_line) or die(mysql_error()); //execute query
$update_line = mysql_fetch_assoc($list_update_line);//gets info in array

do {

echo "<script> line(".$update_line['page_parent'].", ".$update_line['page_child'].", ".$update_line['page_relation_id'].");</script>";

} while ($update_line = mysql_fetch_assoc($list_update_line));

$query_update_line = "Select * from Page_Relations where page_child=".$id; //mysql query variable
$list_update_line = mysql_query($query_update_line) or die(mysql_error()); //execute query
$update_line = mysql_fetch_assoc($list_update_line);//gets info in array

do {

echo "<script> line(".$update_line['page_parent'].", ".$update_line['page_child'].", ".$update_line['page_relation_id'].");</script>";

} while ($update_line = mysql_fetch_assoc($list_update_line));




?>
