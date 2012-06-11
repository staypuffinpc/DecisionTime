<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];

include_once('../../db.php');

?>

<h2>Story Information Editor</h2>
<form>
<table>
<tr>
	<td width="150px" id="story_name_label">Name:</td>
	<td width="200px"><input id="story_name" name="story_name" type="text" width="400px" value="<?php echo $story_info['story_name'];?>" /></td>
</tr>
<tr>
	<td>Topic:</td>
	<td><input id="story_topic" name="story_topic" type="text" cols="40" value="<?php echo $story_info['story_topic']; ?>"/></td>
		
</tr>

<tr>
	<td>First Page:</td>
	<td><select id="story_first_page" name="story_first_page">
		<?php do {
		if ($pages['id'] !== $story_info['story_first_page']) {echo "<option value=".$pages['id'].">".$pages['page_name']."</option>";}
		else {echo "<option value=".$pages['id']." selected>".$pages['page_name']."</option>";}
		} while ($pages = mysql_fetch_assoc($list_pages));
	?>
	</select><?php mysql_data_seek($list_pages, 0); ?></td>
</tr>
<tr>
	<td>Summary Page:</td>
	<td><select id="story_summary" name="story_summary">
		<?php while ($pages = mysql_fetch_assoc($list_pages)) {
		if ($pages['id'] !== $story_info['story_summary']) {echo "<option value=".$pages['id'].">".$pages['page_name']."</option>";}
		else {echo "<option value=".$pages['id']." selected>".$pages['page_name']."</option>";}
		} 
	?>
	</select></td>
</tr>
<tr>
	<td>
	<label>Private</label>
	<input type="radio" name="privacy" value="Private" <?php if ($story_info['story_privacy'] == "Private") {echo 'checked';} ?> />
	</td>
	<td>
	<label>Public</label>
	<input type="radio" name="privacy" value="Public" <?php if ($story_info['story_privacy'] == "Public") {echo 'checked';} ?>/>
	</td>
</tr>
</table>
</form>

<a class="btn" id="update_story" onClick="update_story();">Update story</a>
