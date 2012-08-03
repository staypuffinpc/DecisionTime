<?php
1
$base_directory = dirname(dirname(dirname(__FILE__)))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$query = "Select * from Users"; //mysql query variable
$list = mysql_query($query) or die(mysql_error()); //execute query
$values = "[";
while ($results =mysql_fetch_assoc($list)) {

$values=$values."{value: '".$results['user_id']."',
			label: '".$results['user_name']."',
			icon: '".$results['user_image']."'},";

}

$values=$values."]";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>	

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
	
	
	
	
	
	
	<style>
	#searchForAuthor-label {
		display: block;
		font-weight: bold;
		margin-bottom: 1em;
	}
	#searchForAuthor-icon {
		float: left;
		height: 32px;
		width: 32px;
	}
	#searchForAuthor-description {
		margin: 0;
		padding: 0;
	}
	</style>
	<script>
	$(function() {
		var values = <?php echo $values; ?>;

		$( "#searchForAuthor" ).autocomplete({
			minLength: 0,
			source: values,
			focus: function( event, ui ) {
				$( "#searchForAuthor" ).val( ui.item.label );
				$("#searchForAuthor").hide();
				return false;
			},
			select: function( event, ui ) {
				$( "#searchForAuthor" ).val( ui.item.label );
				$( "#searchForAuthor-id" ).val( ui.item.value );

				return false;
			}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a><img src='" +item.icon + "' />" + item.label + "<br></a>" )
				.appendTo( ul );
		};
	});
	</script>


</head>
<body>
<div>
	<div id="searchForAuthor-label">Select an Author:</div>
	<img id="searchForAuthor-icon" class="ui-state-default"//>
	<input id="searchForAuthor"/>
	<input type="hidden" id="searchForAuthor-id"/>
</div>


</body>
</html>