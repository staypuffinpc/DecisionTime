<?
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$class_id = $_SESSION["class_id"];
$user_id = $_POST["user_id"];

$query = "DELETE FROM Class_Members WHERE user_id = '$user_id' and class_id = '$class_id'";
$run = mysql_query($query) or die(mysql_error());
?>