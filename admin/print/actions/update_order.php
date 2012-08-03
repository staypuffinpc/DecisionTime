<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

foreach($_POST['item'] as $key=>$value) {
	$value=$value+1;
	$query = "Update Pages set print_order='$value' where id='$key'";
	$run = mysql_query($query) or die(mysql_error());
	echo "$key updated to $value.<br />";
	
}
?>
<script>
$.ajax({
	url: "ajax/print.php",
	success: function(phpfile){
		$("#content").html(phpfile);
		addTitles();
	}
});

</script>";

