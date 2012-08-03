<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>
<h2> New Story </h2>
<form>
<table>
<tr>
	<td width="150px" id="story_name_label">Name:</td>
	<td width="200px"><input id="story_name" name="story_name" type="text" width="400px" value="" /></td>
</tr>
<tr>
	<td id="topic">Topic:</td>
	<td><input id="story_topic" name="story_topic" type="text" cols="40" value=""/></td>
		
</tr>
</table>
<br />
</form>
<script>$("#story_name").focus();</script>
<a class="btn" onclick="create_story();">Create Story</a>
