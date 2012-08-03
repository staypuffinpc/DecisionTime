<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$class_name = $_POST['class_name'];
$enroll_code = $_POST['enroll_code'];
$stories = $_POST['stories'];

$query = "Insert into Classes (class_id, class_creator, class_created, class_name, enroll_code) Values (NULL, '$user_id',NOW(), '$class_name', '$enroll_code')"; //mysql query variable
$run = mysql_query($query) or die(mysql_error()); //execute query 
$lastItemID = mysql_insert_id();

foreach($_POST['stories'] as $key=>$value ) {
$query = "Insert into Class_Stories (class_id, story_id) Values ('$lastItemID', '$value')";
$run = mysql_query($query) or die(mysql_error());

}
?>
