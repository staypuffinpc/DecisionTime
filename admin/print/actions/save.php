<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story=$_SESSION['story'];
$name=$_POST['name'];
$content=$_POST['data'];
if ($name !== "null") {
$query = "Select * from Prints where story='$story' and name='$name'";
$run = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($run)<1) {
	$query = "Insert into Prints (story, name, content) values ('$story', '$name', '$content')";
	$run = mysql_query($query) or die(mysql_error());
}
else {
	$query="Update Prints set content = '$content' where name='$name' and story='$story'";
	$run = mysql_query($query) or die(mysql_error());
	
}

}


?>