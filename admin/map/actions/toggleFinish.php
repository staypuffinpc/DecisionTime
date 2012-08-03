<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$page_id = $_POST['id'];

$query = "Select finish_page from Pages where id='$page_id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

if ($results['finish_page'] == "true") {$value = "false";} else {$value = "true";}
/* if ($results['finish_page'] == "false") {$value = "true";} */
$query = "Update Pages set finish_page='".$value."' where id='$page_id'";
$run = mysql_query($query) or die(mysql_error());

?>