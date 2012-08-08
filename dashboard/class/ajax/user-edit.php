<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");

$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
/* include_once('../../db.php'); */

$user_id = $_GET['user_id'];
$class_id = $_SESSION['class_id'];

$query = "Select * from Users where user_id='$user_id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

?>
<h2>User Management</h2>
<?
echo $results['user_name'];
?>
<table>

<?
$query = "Select * from Class_Stories Join Stories on Class_Stories.story_id = Stories.story_id where class_id='$class_id'";
$run = mysql_query($query) or die(mysql_error());
while ($results = mysql_fetch_assoc($run)) {
	?>
	<tr>
	<td align="left">
	<?
	echo $results['story_name']."<br>";
	?>
	</td>
	<td>
	<a class="user-tasks clear-progress <? echo $user_id; ?>" id="<? echo $results['story_id']; ?>">Clear Progress</a>
	</td>
	<td>
	<a class="user-tasks clear-worksheet <? echo $user_id; ?>" id="<? echo $results['story_id']; ?>">Clear Worksheet</a>
	</td>
	<td>
	<a class="user-tasks clear-quiz <? echo $user_id; ?>" id="<? echo $results['story_id']; ?>">Clear Quiz</a>
	</td>
	</tr>
	<?
}


?>