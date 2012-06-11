<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];

$query = "Select page_content from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());


echo "<div id='alltext' style='display:none'>";
while ($results = mysql_fetch_assoc($run)) {
	echo $results['page_content'];

}



echo "</div>";
?>
<script>

$(".keyterm").each(function(){
	term = $(this).text();
	$.ajax({
		type: "POST",
		url: "actions/addTerm.php",
		data: "keyterm="+$(this).text(),
		success: function(a){$("#update").append(a);}
	});
});
</script>
