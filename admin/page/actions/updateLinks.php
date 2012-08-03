<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$page_parent = $_SESSION['current_page'];
$id = $_POST['id'];
$theClass = $_POST['class'];
$text = $_POST['text'];

$search = array("\"","'");
$replace =array("&quot;","&apos;");
$text = str_replace($search, $replace, $text);

$query = "Update Page_Relations set $theClass='$text' where page_relation_id='$id'";
$run = mysql_query($query) or die(mysql_error());

echo "$id updated"; 
?>