<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$page_id = $_SESSION['current_page'];
$story = $_SESSION['story'];
$user_id = $_SESSION['user_id'];
$query = "Select * from Worksheet where worksheet_story='$story' and embedded='1' and worksheet_page='$page_id'";
$run = mysql_query($query) or die(mysql_error());
echo "<div id='check'>check your understanding</div>";

while ($results = mysql_fetch_assoc($run)) {
	echo "<h4>{$results['worksheet_type']}</h4>";
	echo $results['worksheet_text'];
	echo "<br />".$results['worksheet_response'];
	$query = "SELECT * From User_Worksheet where user_id = '".$user_id."' and worksheet_id = '".$results['worksheet_id']."'"; //mysql query variable
	$list = mysql_query($query) or die(mysql_error()); //execute query
	$answers = mysql_fetch_assoc($list);//gets info in array
	
if ($answers['user_answer'] !== NULL) {
	if ($results['worksheet_type'] == "Multiple Choice" || $results['worksheet_type'] == "True or False") {
		?>
		<script>$("input[name='<?php echo $results['worksheet_id'];?>']")[<?php echo $answers['user_answer']; ?>].checked = true;</script>
		<?php
	}
 	if ($results['worksheet_type'] == "Fill in the Blank") {
 		?>
		<script>$("input[name='<?php echo $results['worksheet_id'];?>']").val("<?php echo $answers['user_answer']; ?>");</script>
		<?php
 	}
	if ($results['worksheet_type'] == "Short Answer") {
 		?>
		<script>$("textarea[name='<?php echo $results['worksheet_id'];?>']").val("<?php echo $answers['user_answer']; ?>");</script>
		<?php
 	}
}
	
	
}
	
	
	?>
	
	