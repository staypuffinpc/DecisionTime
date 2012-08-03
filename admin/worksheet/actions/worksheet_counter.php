<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$user_id = $_SESSION['user_id'];

$query = "Select story_worksheet_count from Stories where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$worksheet_order = $results['story_worksheet_count']+1;

$query = "Update Stories set story_worksheet_count='$worksheet_order' where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());

?>