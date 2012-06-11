<h2>Content Borrower</h2>
<?php
$query = "Select id, page_name from Pages";
$run = mysql_query($query) or die(mysql_error());
$data = array();
?>
<script>
var data = new Array();
function getContent() {
	id = $("#page").val();
	$.ajax({
		type: "POST",
		url: "actions/getContent.php",
		data: "id="+id,
		success: function(phpfile) {
			$("#borrowedContent").html(phpfile);
		}
	
	});
}

</script>
Source Page: <select id='page' onChange="getContent();">
	<?php
	while ($results = mysql_fetch_assoc($run))
	{
	echo "<option value='".$results['id']."'>".$results['page_name']."</option>";
	}
	?>
</select>
<div id="borrowedContent"></div>
