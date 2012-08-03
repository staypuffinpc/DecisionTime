<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$id=$_POST['page'];
$top = $_POST['top'];
$left = $_POST['left'];
$magT = $_SESSION['magT'];
$magL = $_SESSION['magL'];
$x = $_SESSION['x'];
$ph = $_SESSION['ph'];
$new_top = $top/$x + $ph + 4/$x+2;
$update = "UPDATE Pages SET 
page_left = '".$left."', 
page_top = '".$top."'
WHERE id=".$id;
$result = mysql_query($update) or die(mysql_error());

echo "Location Updated for page ".$id.".<br />";

$query_update_line = "Select * from Page_Relations where page_parent=".$id; //mysql query variable
$list_update_line = mysql_query($query_update_line) or die(mysql_error()); //execute query


while ($update_line = mysql_fetch_assoc($list_update_line)) {
	if ($update_line['page_external'] == "true")
		{echo "<script>//console.log('first');$('#line".$update_line['page_relation_id']."').css({'top':".$new_top.",'left': ".$left/$x."});</script>";}		
	else
		{echo "<script> line(".$update_line['page_parent'].", ".$update_line['page_child'].", ".$update_line['page_relation_id'].", ".$magT.", ".$magL.");</script>";}

} 

$query_update_line = "Select * from Page_Relations where page_child=".$id; //mysql query variable
$list_update_line = mysql_query($query_update_line) or die(mysql_error()); //execute query


while ($update_line = mysql_fetch_assoc($list_update_line)) {
	if ($update_line['page_external'] == "true")
		{echo "<script>//console.log('first');$('#line".$update_line['page_relation_id']."').css({'top':".$new_top.",'left': ".$left."});</script>";}		
	else
		{echo "<script> line(".$update_line['page_parent'].", ".$update_line['page_child'].", ".$update_line['page_relation_id'].", ".$magT.", ".$magL.");</script>";}

} 




?>
