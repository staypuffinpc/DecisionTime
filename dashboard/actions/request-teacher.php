<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];

$query = "Select * from Users where user_id='$user_id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);


$email = "benmcmurry@gmail.com";
$message = $results['user_name']." is requesting to be a teacher. id: ".$results['user_id'];
$subject = "Teacher Request";
mail($email, $subject, $message);
echo $email;

?>