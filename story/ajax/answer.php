<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$id = $_POST['id'];

$query = "Select worksheet_answer from Worksheet where worksheet_id='$id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

echo "<p>".$results['worksheet_answer']."</p>";



?>