<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");

$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
/* include_once('../../db.php'); */


?>
<h2>Add Member</h2>
<?
$query = "Select * from Users"; //mysql query variable
$list = mysql_query($query) or die(mysql_error()); //execute query
$values = "[";
while ($results =mysql_fetch_assoc($list)) {

$values=$values."{value: '".$results['user_id']."',
			label: '".$results['user_name']."',
			icon: '../".$results['user_image']."'},";

}

$values=$values."]";



?>
<script>

	$(function() {
		var values = <?php echo $values; ?>;

		$( "#searchForUser" ).autocomplete({
			minLength: 0,
			source: values,
			focus: function( event, ui ) {
				$( "#searchForUser" ).val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
				$("#searchForUser").val( ui.item.label );
				$("#searchForUser-id").val( ui.item.value );
				selectedValues = $("#searchForUserForm").serialize();
				$.ajax({
						type: "POST",
							url: "actions/add_User.php",
							data: selectedValues,
							success: function(phpfile){
							$("#added").html(phpfile);}
						});
				$("#member-list-info").load("ajax/member-list.php");
				return false;
			}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a><img class='icon' src='" +item.icon + "' />" + item.label + "<br></a>" )
				.appendTo( ul );
		};
	});


</script>

<h4>Add Another User</h4>

<form id="searchForUserForm">
	<div class="ui-widget">
	<input type="text" name="searchForUser" id="searchForUser" value="" />
	<input type="hidden" name="searchForUser-id" id="searchForUser-id" value="" />
	</div>
</form>
<div id="added"></div>