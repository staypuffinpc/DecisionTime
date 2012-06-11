<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../../db.php');
$page_stem = $_POST['page_stem'];
$page_link = $_POST['page_link'];
$page_punctuation = $_POST['page_punctuation'];
$page_relation_id = $_POST['page_relation_id'];

$search = array("\"","'");
$replace =array("&quot;","&apos;");
$page_stem = str_replace($search, $replace, $page_stem);
$page_link = str_replace($search, $replace, $page_link);
$page_punctuation = str_replace($search, $replace, $page_punctuation);


$query_update = "Update Page_Relations Set
page_stem = '$page_stem',
page_link = '$page_link',
page_punctuation = '$page_punctuation'
Where page_relation_id='$page_relation_id'"; //mysql query variable
$list_update = mysql_query($query_update) or die(mysql_error()); //execute query




echo $page_relation_id." updated.<br />";

?>