<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../../db.php');
$user_id=$_SESSION['user_id'];



$query="Insert into Pages (id, story, page_author, page_created, page_top, page_left) Values (NULL, '$story','$user_id',NOW(), 120, 0)";
$list_query = mysql_query($query) or die(mysql_error()); //execute query
$lastItemID = mysql_insert_id();
$new_page = "<div class='page temp-new-page' id='".$lastItemID."'>".$new_pages['page_name']."<div class='edit-page' id='edit".$lastItemID."'></div><div class='delete' id='delete".$lastItemID."'></div><div class='relate' id='relate".$lastItemID."' title='Add New Connection'></div></div>";
echo "New Page. <br />";
echo "<script>location.reload();</script>"

?>

Page Created <br />

