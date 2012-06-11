<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */ //authenticates

$user_id = $_SESSION['user_id'];//gets user info
$story = $_SESSION['story'];
$term = $_POST['term'];
$definition = $_POST['definition'];
$term_id = $_POST['term_id'];



$update = <<<EOF
	UPDATE 
		Terms 
	SET 
		term = "$term", 
		definition ="$definition",
		story = $story,
		term_modified_by = $user_id,
		term_modified_on = NOW()
		WHERE term_id=$term_id
EOF;


$result = mysql_query($update) or die(mysql_error());

echo "Last Saved: <br />";
echo date("m/d/y @ H:i:s", time());
?>