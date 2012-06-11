<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$query = "Select * From Stories JOIN Users on Stories.story_creator = Users.user_id";
$list_stories = mysql_query($query) or die(mysql_error()); //execute query

?>
<h2>New Class</h2>
<form>
<table>
<tr>
	<td width="150px" id="class_name_label" style="vertical-align:top;text-align:left;">Name:</td>
	<td width="400px"><input class='inputClass' id="class_name" name="class_name" type="text" value="" /></td>
</tr>
<tr>
	<td width="150px" id="class_enroll_code_label" style="vertical-align:top;text-align:left;">Enroll Code:</td>
	<td width="400px"><input class='inputClass' id="enroll_code" name="enroll_code" type="text" value="" /></td>
</tr>
<tr>
	<td id="story_list_label" style="vertical-align:top;text-align:left;">Class Stories
	<p>Use CTRL+click to select multiple stories. (CMD+click for Macs)</p>
	
	</td>
	<td width="400px">
		<select id='stories' name='stories[]' multiple='multiple' class='inputClass'>
	<?php 
	while ($stories = mysql_fetch_assoc($list_stories)) { 
	
	$query = "Select * from Author_Permissions where user_id=$user_id and story_id=".$stories['story_id']; //mysql query variable
	$list_query = mysql_query($query) or die(mysql_error()); //execute query
	$results = mysql_fetch_assoc($list_query);//gets info in array

	if ($stories['story_privacy'] == "Public" || $stories['story_creator'] == $user['user_id'] || $user['role'] == "Admin" || $results['id']) {

	echo "<option value='".$stories['story_id']."'>".$stories['story_name']."</option>";
	
	}
}
 

 
 
 ?>
		</select>
	
	</td>

</tr>
</table>
<br />
</form>
<script>
$("#class_name").focus();
$("#class_name").blur(function(){
	enroll_code = $("#class_name").val();
	enroll_code = enroll_code.toUpperCase();
	enroll_code = enroll_code.split(' ').join('-');
	enroll_code = enroll_code.split("'").join("");
	enroll_code = enroll_code.split("\"").join("");

	$("#enroll_code").val(enroll_code);
});


</script>
<a class="btn" onclick="create_class();">Create Class</a>
