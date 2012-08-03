<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$id=$_POST['id'];

$query = "Select * from Prints where id='$id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);
echo $results['content'];
echo "<script>$('#filename').html('Filename: {$results['name']}');defaultName='{$results['name']}';</script>";

?>
