<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$query = "Select * from Pages where story='$story' and page_type='Teaching' order by print_order ASC";
$run = mysql_query($query) or die(mysql_error());
while ($results = mysql_fetch_assoc($run)) {

echo "<li id='item[".$results['id']."]'>".$results['page_name']."</li>";

}


?>