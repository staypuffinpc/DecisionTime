<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story=$_SESSION['story'];
$query = "Select id, story, name from Prints where story='$story'";
$run = mysql_query($query) or die(mysql_error());
while ($results = mysql_fetch_assoc($run)) {
echo "<a class='saved' id='".$results['id']."'>".$results['name']."</a>";

}

?>