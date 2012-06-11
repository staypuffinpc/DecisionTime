<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$user_id = $_SESSION['user_id'];
$keyterm = $_POST['keyterm'];
$query = "Select term_id from Terms where term like '%$keyterm%'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

if(mysql_num_rows($run)<1) {
	$query = "Insert into Terms (term, definition, story, term_author, term_created) values ('$keyterm', ' No definition provided', '$story', '$user_id', NOW())";
	$do = mysql_query($query) or die(mysql_error());
	echo "$keyterm added.<br />";	

}



?>