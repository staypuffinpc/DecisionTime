<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story=$_SESSION['story'];
$user_id=$_SESSION['user_id'];
$type=$_POST['type'];
$embedded = $_POST['embedded'];
if ($embedded == 1) {$worksheet_page = $_SESSION['current_page'];} else {$worksheet_page = 000;}

switch ($type) {
	case "short_answer":
	$type = "Short Answer";
	break;
	case "multiple_choice":
	$type = "Multiple Choice";
	break;
	case "true_false":
	$type = "True or False";
	break;
	case "fill_in_the_blank";
	$type = "Fill in the Blank";
	break;
}

$query = <<<EOF
	Insert into Worksheet (worksheet_text, worksheet_answer, worksheet_story, worksheet_order, worksheet_type, created_by, created_on, embedded, worksheet_page) values ("Insert question or statement here.","Insert your answer here", "$story", "0", "$type", "$user_id", NOW(), "$embedded", "$worksheet_page") 
EOF;
$run = mysql_query($query) or die(mysql_error());
$lastItemID = mysql_insert_id();

switch ($type) {
	case "Short Answer":
	$query = <<<EOF
	Update Worksheet set worksheet_response = "<textarea name='$lastItemID'></textarea><br />" where worksheet_id='$lastItemID'
EOF;
		break;
	case "Multiple Choice":
	$query = <<<EOF
	Update Worksheet set worksheet_response = "<input type='radio' name='$lastItemID' value='0'><div class='ce response $lastItemID'>Choice A</div><br>
	<input type='radio' name='$lastItemID' value='1'><div class='ce response $lastItemID'>Choice B</div><br />
	<input type='radio' name='$lastItemID' value='2'><div class='ce response $lastItemID'>Choice C</div><br />
	<input type='radio' name='$lastItemID' value='3'><div class='ce response $lastItemID'>Choice D</div><br />
	<input type='radio' name='$lastItemID' value='4'><div class='ce response $lastItemID'>Choice E</div><br />" where worksheet_id='$lastItemID'
EOF;
		break;
	case "True or False":
	$query = <<<EOF
	Update Worksheet set worksheet_response = "<input type='radio' name='$lastItemID' value='0'>True<br>
	<input type='radio' name='$lastItemID' value='1'>False<br>" where worksheet_id='$lastItemID'
EOF;
		break;
	case "Fill in the Blank";
	$query = <<<EOF
	Update Worksheet set worksheet_response = "<input type='text' name='$lastItemID' /><br />" where worksheet_id='$lastItemID'
EOF;
	break;
}

echo $query;
$run = mysql_query($query) or die(mysql_error());

include("worksheet_counter.php");
echo "<script>$('#item-list').load('ajax/worksheetList.php');</script>";
?>
