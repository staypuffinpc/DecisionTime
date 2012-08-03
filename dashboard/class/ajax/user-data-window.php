<h4>Click on a story to see user data</h4>

<?
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$class_id = $_SESSION['class_id'];

$query = "Select * from Stories Join Class_Stories on Class_Stories.story_id = Stories.story_id where class_id=$class_id";

$run = mysql_query($query) or die(mysql_error());
?>
<table>
<?
while ($results = mysql_fetch_assoc($run)) {
	?>
		<tr>
			<td><? echo $results['story_name']; ?></td>
			<td><a class="management-links worksheet-data">Worksheet Data</a></td>
			<td><a class="management-links quiz-data">Quiz Data</a></td>
			<td><a class="management-links clear-worksheet">Clear Worksheet</a></td>
			<td><a class="management-links clear-quiz">Clear Quiz</a></td>
		</tr>
	<?	
}
?>
</table>
