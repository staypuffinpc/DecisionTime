<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$class_id = $_POST['class_id'];


foreach($_POST['story'] as $key=>$value) {
	$value=$value+1;
	$query = "DELETE FROM Class_Stories WHERE class_id = '$class_id' and story_id = '$key'";
	$run = mysql_query($query) or die(mysql_error());
}

echo "Removed";
