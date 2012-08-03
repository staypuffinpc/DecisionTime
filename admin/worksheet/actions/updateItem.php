<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$field = $_POST['field'];
$text = $_POST['text'];
$id = $_POST['id'];
if ($field == "response") {
$x = array("true");
$y = array("false");
$text = str_replace($x, $y, $text);
}
else {
}
$query = "Update Worksheet set worksheet_$field='$text' where worksheet_id='$id'";
$run = mysql_query($query) or die(mysql_error());
echo "Updated to $text.";