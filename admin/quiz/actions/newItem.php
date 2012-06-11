<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
switch ($_POST['type']) {
	case "mc":
	$item_type = "Multiple Choice";
	$item_prompt = "Type the prompt here. Add choices by clicking on the \"Add New Response\" button.";
	break;
	case "fb":
	$item_type = "Fill in the Blank";
	$item_prompt = "Type the prompt here. Add a set of underscores for the location of the missing word. <br />Example: What\'s up _______?<br />Click on the \"Add New Response\" button to add possible correct answers.";	
	break;
}

$story = $_SESSION['story'];
$user_id = $_SESSION['user_id'];

$query = "Insert into Quiz_Items (story_id, item_prompt, item_type, created_by, created_on) values ('$story', '$item_prompt', '$item_type', '$user_id', NOW())";
$run = mysql_query($query) or die(mysql_error());

echo "Item Added."



?>