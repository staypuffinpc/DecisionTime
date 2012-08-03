<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../../db.php');
/*
$page_stem = $_POST['page_stem'];
$page_link = $_POST['page_link'];
$page_punctuation = $_POST['page_punctuation'];
*/
$page_relation_id = $_POST['page_relation_id'];


$query = "DELETE from Page_Relations where page_relation_id='$page_relation_id'";
$list = mysql_query($query) or die(mysql_error()); //execute query

echo $page_relation_id." deleted.<br />";

echo "<script> $('#line".$page_relation_id."').hide();</script>";

?>
