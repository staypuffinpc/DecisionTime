<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../../db.php');
$page_id = $_POST['page_id'];
$page_name = $_POST['page_name'];
$page_content = $_POST['content'];
$page_references = $_POST['references'];
$page_summary = $_POST['page_summary'];
$page_navigation_text = $_POST['page_navigation_text'];
$page_type = $_POST['page_type'];

$page_content = preg_replace(array('/style="(.*?)"/','/<span(.*?)>/', '/<\/span>/','/<font(.*?)>/', '/<\/font>/', '/<strong><\/strong>/', '/<p><\/p>/','/ class="Standard"/'),'', $page_content);

$user_id=$_SESSION['user_id'];

$update = "UPDATE Pages SET 
page_name = '$page_name', 
page_content = '$page_content', 
page_references = '$page_references', 
page_type = '$page_type', 
page_summary = '$page_summary',
page_navigation_text = '$page_navigation_text',
modified_by = '$user_id',
modified_date=NOW() 
WHERE id='".$page_id."'";
$result = mysql_query($update) or die(mysql_error());


echo "Last Saved:";
echo date("d/m/y : H:i:s", time());



?>