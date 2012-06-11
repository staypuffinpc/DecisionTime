<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];




$user_id = $_POST['searchForAuthor-id'];
$user_name = $_POST['searchForAuthor'];




$query = "select * from Author_Permissions where user_id = $user_id and story_id = $story";
$list = mysql_query($query) or die(mysql_error()); 
$results = mysql_fetch_assoc($list);//gets info in array
if (!$results['id']) {
	$query = "Insert into Author_Permissions (user_id, story_id) values ($user_id, $story)";
	$list = mysql_query($query) or die(mysql_error()); //execute query
	echo "Author ".$user_name." Added!";
}
?>